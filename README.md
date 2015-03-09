# TeleinConnector
Scripts AGI para integração com o webservice Telein (portabilidade numérica)

##Dependências
  * PHP >= 5.3 < 6 (http://php.net)
  * PHP-curl extension
  * PHP-pcre extension
  * Composer (http://getcomposer.org)

##Instalaćão
Clone o projeto para um diretório de seu sistema:
`git clone https://github.com/hmayer/TeleinConnector.git`

Crie ou atualize o diretório vendor utilizado pelo composer com:
`php /path/to/composer.phar dump-autoload`

##Configuraćão
As općões de configuraćão do TeleinConnector ficam no arquivo settings.json,
copie o arquivo default.settings.json para settings.json:
`cp default.settings.json settings.json`
Edite conforme suas necessidades, os campos do arquivo são:
  * **key** - string: Chave da sua conta, fornecida pela Telein
  * **connect_timeout** - int(ms): Tempo de espera para o script conectar ao servidor, caso haja expiraćão, ele automaticamente passa para o próximo servidor na lista
  * **timeout** - int(ms): Diferente da općão connect_timeout, este é o tempo que o script fica esperando o servidor responder a consulta, tem o mesmo comportamento de connect_timeout em caso de expiraćão
  * **query** - string(operator|rn10: modo de retorno do código da operadora, qeu pode retornar o código de discagem (eg. 20) ou o código rn1 (eg. 553098)
  * **servers** - array: Lista dos servidores Telein, predefinida, mas disponível para futuras alteraćões.

##run.php
O arquivo run.php vem como um exemplo de uso do TeleinConnect para sistemas
Asterisk, executado à poartir do dial plan (AGI)

##Configurando o Asterisk
Para o uso do TeleinConnector com o Asterik, basta chamar o script run.php
no dial plan (AGI) e utilizar as variáveis TELEIN_ROUTE e TELEIN_ERROR conforme
exemplo:

```
[default]
exten => _X.,1,AGI(/<path to>/php,/<path to>/TeleinConnector/run.php,<msisdn>)
exten => _X.,n,Goto(operator-${TELEIN_ROUTE},${EXTEN},1)
```
