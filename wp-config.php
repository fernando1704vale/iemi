<?php
/** 
 * As configurações básicas do WordPress.
 *
 * Esse arquivo contém as seguintes configurações: configurações de MySQL, Prefixo de Tabelas,
 * Chaves secretas, Idioma do WordPress, e ABSPATH. Você pode encontrar mais informações
 * visitando {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. Você pode obter as configurações de MySQL de seu servidor de hospedagem.
 *
 * Esse arquivo é usado pelo script ed criação wp-config.php durante a
 * instalação. Você não precisa usar o site, você pode apenas salvar esse arquivo
 * como "wp-config.php" e preencher os valores.
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar essas informações com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'iemi');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'iemi');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'HsCbWGDf');

/** nome do host do MySQL */
define('DB_HOST', 'mysql.iemi.com.br');

/** Conjunto de caracteres do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8');

/** O tipo de collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * Você pode alterá-las a qualquer momento para desvalidar quaisquer cookies existentes. Isto irá forçar todos os usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '93|=iI#Bu#19BTp,9B.HtK7o+YM|@=/duMa=NaWZdseRIS_q{}<[nYFq-A*6N`yg');
define('SECURE_AUTH_KEY',  'u;(6r-+A6i@ycy!B#%n+YYW(I+MbZ<&HTAaa^vk4Ru>>h-%_m(xTDn(HOWmE$JFR');
define('LOGGED_IN_KEY',    '>B+,9H<<QK?n)Yv #uC|s3L2dXmO?,q~R7g4t<*2<{7gNbj-Y-)}}8TO3/L>zoBl');
define('NONCE_KEY',        'xf-zc6gPXVD,eYPA}}ZgII<5jj`6|R>A%~Vj[d6w&${ZDW}|TIO$Ye$>9R)Z<H&|');
define('AUTH_SALT',        'd$~|OxdmvWAXj #h|^(xB+=9hLGjDPew.^[;s|+U2Yd=#+/4{+XovWYmQ:{SsMvI');
define('SECURE_AUTH_SALT', '`2n_w,RAFaoFW3FR>IRY0k`F=<--fS~{+h`e+;}TL|=Qm_/.-jj;$ONXz;+CCfek');
define('LOGGED_IN_SALT',   'F<7|77$uR{3-q[hFT.Zy|iF,Wn_{w/O=2ou^l9xidWCZH3:LB|CHqN]+=d~lPYEn');
define('NONCE_SALT',       '7mV`=KzMU9|_63kylg%[4w+>R`xr^ZOjlmGRI,/H#+~0;_W/YA=:{~c^=[<w~JOi');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der para cada um um único
 * prefixo. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_test_';

/**
 * O idioma localizado do WordPress é o inglês por padrão.
 *
 * Altere esta definição para localizar o WordPress. Um arquivo MO correspondente ao
 * idioma escolhido deve ser instalado em wp-content/languages. Por exemplo, instale
 * pt_BR.mo em wp-content/languages e altere WPLANG para 'pt_BR' para habilitar o suporte
 * ao português do Brasil.
 */
define('WPLANG', 'pt_BR');

/**
 * Para desenvolvedores: Modo debugging WordPress.
 *
 * altere isto para true para ativar a exibição de avisos durante o desenvolvimento.
 * é altamente recomendável que os desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');
	
/** Configura as variáveis do WordPress e arquivos inclusos. */
require_once(ABSPATH . 'wp-settings.php');
