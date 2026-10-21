<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotação de Moedas</title>
    <link rel="stylesheet" href="{{ asset('css/cotacao.css') }}">
</head>
<body>
    <main>
        <h1>Cotação de Moedas</h1>
        <p class="fonte">Dados da AwesomeAPI</p>

        @if (empty($cotacoes))
            <p class="erro">Não foi possível consultar a API agora.</p>
        @else
            <div class="cards">
                @foreach ($cotacoes as $c)
                    <div class="card">
                        <h2>{{ $c['moeda'] }}</h2>
                        <p class="nome">{{ $c['nome'] }}</p>
                        <p class="valor">R$ {{ number_format($c['compra'], 2, ',', '.') }}</p>
                        <p class="{{ $c['variacao'] >= 0 ? 'alta' : 'baixa' }}">
                            {{ $c['variacao'] >= 0 ? '▲' : '▼' }} {{ $c['variacao'] }}%
                        </p>
                        <small>{{ $c['atualizado_em'] }}</small>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
</body>
</html>