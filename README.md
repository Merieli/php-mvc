# Projeto de PHP em MVC

Comando para executar o Projeto

```sh
# Inicia a execução de um servidor web embutido do PHP em nossa máquina, na porta 8080.
php -S localhost:8080
```

Para executar o projeto dentro do container docker
```sh
php -S 0.0.0.0:8080
```

# Super globais do PHP

- `$_FILES`: que contém um array dos arquivos enviados via upload em um formulário utilizando o verbo/método POST;
- `$_COOKIE`: que contém um array associativo com todos os cookies enviados na requisição;
- `$_SESSION`: que nos permite acessar e definir informações na sessão;
- `$_REQUEST`: que possui todos os valores de $_GET, $_POST e $_COOKIE;
- `$_ENV`: que contém todas as variáveis de ambiente passadas para o processo do PHP;
- `$_SERVER`: que possui informações do servidor Web, como os cabeçalhos da requisição, o caminho acessado, etc. Todas as chaves desse array são criadas pelo servidor web, então elas podem variar de servidor para servidor.

## Post Redirect GET

É uma forma de no PHP evitar o reenvio de formulários quando um usuário atualiza a página após submeter dados. Este padrão funciona da seguinte maneira:

1. O usuário envia um formulário via método POST
2. O servidor processa os dados do formulário
3. Em vez de renderizar diretamente uma resposta, o servidor redireciona (via código HTTP 302) para outra URL
4. O navegador então faz uma nova requisição GET para essa URL
5. O servidor responde com o conteúdo apropriado

### Benefícios:

- Evita o problema de reenvio de formulários quando o usuário atualiza a página
- Melhora a experiência do usuário ao evitar mensagens de confirmação de reenvio
- Mantém a URL limpa e adequada para o conteúdo exibido
- Facilita a implementação de mensagens flash (feedback temporário)

Este padrão é especialmente útil em arquiteturas MVC para manter a separação clara entre processamento de dados e apresentação de conteúdo.
