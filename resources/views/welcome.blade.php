<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>API de dados sobre covid do estado de são paulo</title>
    <style>
        * {
            font-family: 'Helvetica', sans-serif;
            color: black;
        }
        p {
            margin: 0;
        }
        a {
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <blockquote>
        <h3>API de dados sobre covid do estado de são paulo.</h3>
        <p>Dados retirados do repositório oficial: <a target="_blank" href="https://github.com/seade-R/dados-covid-sp">https://github.com/seade-R/dados-covid-sp</a></p>
        <p>Mais informações: <a target="_blank" href="https://www.seade.gov.br/coronavirus/">https://www.seade.gov.br/coronavirus/</a></p>

        <h4>Requisições</h4>
        <p>É necessário fazer uma chamada HTTP, método GET, para a URL:</p> 
        <p><strong>http://{{ $_SERVER['HTTP_HOST'] }}/api/city/</strong><code>&lt;city&gt;</code>/</p>

        <h4>Parâmetros de URL</h4>
        <p>Parâmetro obrigatório em todas as requisições:</p>
        <p><strong>city:</strong> Cidade que deseja consultar</p>
        <p><strong>Tipo:</strong> String</p>

        <h4>Respostas</h4>
        <p>As Respostas são retornadas no formato JSON.</p>
        <h4>Exemplo de URL</h4>
        <p>http://{{ $_SERVER['HTTP_HOST'] }}/api/city/sao-paulo/</p>
    </blockquote>
</body>
</html>