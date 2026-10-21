<?php

namespace Tests\Feature;

use App\Models\Produto;
use App\Services\ProdutoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class ProdutoTest extends TestCase
{
    use RefreshDatabase;

    public function test_cria_produto_com_sucesso(): void
    {
        $this->postJson('/api/produtos', [
            'nome' => 'Lajota',
            'preco_custo' => 100,
            'preco' => 110,
        ])->assertCreated();

        $this->assertDatabaseHas('produtos', [
            'nome' => 'Lajota',
        ]);
    }

    public function test_nao_cria_produto_com_preco_abaixo_da_margem(): void
    {
        $this->postJson('/api/produtos', [
            'nome' => 'Lajota',
            'preco_custo' => 100,
            'preco' => 105,
        ])->assertStatus(422)
          ->assertJsonValidationErrors('preco');

        $this->assertDatabaseMissing('produtos', [
            'nome' => 'Lajota',
        ]);
    }

    public function test_service_atualiza_produto_com_sucesso(): void
    {
        $produto = Produto::create([
            'nome' => 'Lajota',
            'preco_custo' => 100,
            'preco' => 110,
        ]);

        $service = new ProdutoService();

        $service->update($produto, [
            'nome' => 'Lajota Premium',
            'preco' => 150,
        ]);

        $produto->refresh();

        $this->assertEquals('Lajota Premium', $produto->nome);
        $this->assertEquals(150, $produto->preco);
    }

    public function test_service_nao_atualiza_produto_com_preco_abaixo_da_margem(): void
    {
        $produto = Produto::create([
            'nome' => 'Lajota',
            'preco_custo' => 100,
            'preco' => 110,
        ]);

        $service = new ProdutoService();

        try {
            $service->update($produto, ['preco' => 105]);
            $this->fail('Deveria ter lançado ValidationException');
        } catch (ValidationException $e) {
            $this->assertArrayHasKey('preco', $e->errors());
        }

        $this->assertEquals(110, $produto->fresh()->preco);
    }
}