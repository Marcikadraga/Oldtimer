<?php use app\core\pdo\CustomStatementDebug; ?>

<style>
    #statusbar-dropdown-button {
        position: fixed;
        bottom: 10px;
        right: 10px;
    }

    #statusbar-dropdown-content {
        display: none;
        position: absolute;
        align-items: center;
        justify-content: center;
        left: 0;
        right: 0;
        bottom: 100px;
        margin-left: auto;
        margin-right: auto;
        width: 95%;
        height: 85%;
        box-shadow: 0 5px 20px 5px rgb(0 0 0 / 30%);
        z-index: 9999;
        overflow: scroll;
        background-color: white;
        color: black;
    }

    #statusbar-dropdown-content [href = "#statusbar-tab-content-files-limit-helper"] {
        cursor: pointer;
    }

    #statusbar-dropdown-content .cell-clipboard-button {
        width: 30px;
        text-align: center;
    }

    #statusbar-dropdown-content .cell-clipboard-button button {
        width: 1.3rem;
        height: 1.3rem;
        color: black;
        background-color: black;
        -webkit-mask: url(/assets/svg/Clipboard.svg) no-repeat center;
        mask: url(/assets/svg/Clipboard.svg) no-repeat center;
    }
</style>

<button id = "statusbar-dropdown-button" type = "button" class = "btn btn-secondary dropdown-toggle fade">|</button>
<aside id = "statusbar-dropdown-content">
    <ul class = "nav nav-tabs">
        <li class = "nav-item" title = "A view-ban elérhető változók">
            <a class = "nav-link p-3 active" data-toggle = "tab" href = "#statusbar-tab-content-context">$context</a>
        </li>
        <li class = "nav-item" title = "A session tartalma">
            <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-session">$_SESSION</a>
        </li>
        <li class = "nav-item" title = "A $_GET tömb tartalma">
            <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-get">$_GET</a>
        </li>
        <li class = "nav-item" title = "A $_POST tömb tartalma">
            <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-post">$_POST</a>
        </li>
        <li class = "nav-item" title = "A $_FILES tömb tartalma (nem a fájlok, csak az adataik)">
            <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-files">$_FILES</a>
        </li>
        <li class = "nav-item" title = "A $_COOKIE tömb tartalma">
            <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-cookie">$_COOKIE</a>
        </li>
        <li class = "nav-item" title = "A $_SERVER tömb változó">
            <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-server">$_SERVER</a>
        </li>
        <li class = "nav-item" title = "A rendszer környezeti változói (ha nem találnál valamit)">
            <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-globals">Globals</a>
        </li>
        <li class = "nav-item" title = "A kérés és válasz fejlécei">
            <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-header">Headers</a>
        </li>
        <li class = "nav-item" title = "A lefutott mysql queryk">
            <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-mysql-query">Executed queries</a>
        </li>
        <li class = "nav-item">
            <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-system">System</a>
        </li>
        <li class = "nav-item">
            <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-design-mode">CSS helper</a>
        </li>
    </ul>
    <div class = "tab-content">
        <div class = "tab-pane fade show active" id = "statusbar-tab-content-context">
            <?php if (!isset($context) || !is_array($context)): ?>
                <p class = "text-center text-danger m-5">A Response osztály render függvényében nem létezik a $context változó (átnevezted a változókat?)</p>
            <?php else: ?>
                <?php if (empty($context)): ?>
                    <table class = "table table-bordered table-hover m-0">
                        <tr class = "bg-light">
                            <td class = "w-25"><strong>A betöltött view fájl</strong></td>
                            <td>
                                <?php if (!isset($path)): ?>
                                    <span class = "text-danger">Hiba! A Response osztály render függvényében nem létezik a $path változó (átnevezted a render függvényben?)</span>
                                <?php else: ?>
                                    <?= $path; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                    <p class = "text-center m-5">A view nem kapott változókat.</p>
                <?php else: ?>
                    <table class = "table table-bordered table-hover m-0">
                        <tr class = "bg-light">
                            <td class = "w-25"><strong>A betöltött view fájl</strong></td>
                            <td>
                                <?php if (!isset($path)): ?>
                                    <span class = "text-danger">Hiba! A Response osztály render függvényében nem létezik a $path változó (átnevezted a render függvényben?)</span>
                                <?php else: ?>
                                    <?= $path; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php foreach ($context as $key => $value): ?>
                            <tr>
                                <td class = "w-25"><strong><?= $key ?></strong></td>
                                <td>
                                    <pre class = "mb-0"><?= var_export($value) ?></pre>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class = "tab-pane fade" id = "statusbar-tab-content-session">
            <?php if (session_status() !== PHP_SESSION_ACTIVE): ?>
                <p class = "text-center m-5">A session nem indult el.</p>
            <?php else: ?>
                <table class = "table table-bordered table-hover m-0">
                    <?php foreach ($_SESSION as $key => $value): ?>
                        <tr>
                            <td class = "w-25"><strong><?= $key ?></strong></td>
                            <td>
                                <pre class = "mb-0"><?= var_export($value) ?></pre>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
        <div class = "tab-pane fade" id = "statusbar-tab-content-get">
            <?php if (empty($_GET)): ?>
                <p class = "text-center m-5">A $_GET üres.</p>
            <?php else: ?>
                <table class = "table table-bordered table-hover m-0">
                    <?php foreach ($_GET as $key => $value): ?>
                        <tr>
                            <td class = "w-25"><strong><?= $key ?></strong></td>
                            <td>
                                <pre class = "mb-0"><?= filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS) ?></pre>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
        <div class = "tab-pane fade" id = "statusbar-tab-content-post">
            <?php if (empty($_POST)): ?>
                <p class = "text-center m-5">A $_POST üres.</p>
            <?php else: ?>
                <table class = "table table-bordered table-hover m-0">
                    <?php foreach ($_POST as $key => $value): ?>
                        <tr>
                            <td class = "w-25"><strong><?= $key ?></strong></td>
                            <td>
                                <pre class = "mb-0"><?= filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS) ?></pre>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
        <div class = "tab-pane fade" id = "statusbar-tab-content-files">
            <?php if (empty($_FILES)): ?>
                <p class = "text-center m-5">A $_FILES üres.</p>
            <?php else: ?>
                <table class = "table table-bordered table-hover m-0">
                    <?php foreach ($_FILES as $key => $value): ?>
                        <tr>
                            <td class = "w-25"><strong><?= $key ?></strong></td>
                            <td>
                                <pre class = "mb-0"><?= gettype($value) == 'string' ? $value : var_export($value) ?></pre>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
            <div class = "alert alert-secondary alert-dismissible fade show mt-5 ml-4 mr-4 mb-4">
                <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close">
                    <span aria-hidden = "true">&times;</span>
                </button>
                <p class = "text-danger mb-0" data-toggle = "collapse" href = "#statusbar-tab-content-files-limit-helper">
                    A post_max_size és a max_file_uploads kritikus korlátok a szerveren! Ha az értéküknél nagyobb mennyiségű adat érkezik, akkor a php 0. soros hibával elszáll (gyakorlatilag el sem indul).<br>
                    Az ilyen hibákat nem lehet kezelni (logolni vagy visszajelezni a böngészőnek), ezért ezeket a korlátokat a js-ben is ellenőrizni kell!
                </p>
                <div class = "collapse mt-3" id = "statusbar-tab-content-files-limit-helper">
                    <p>
                        <a href = "https://www.php.net/manual/en/ini.core.php#ini.post-max-size" target = "_blank" class = "font-weight-bold text-dark">post_max_size</a>:
                        <?= ini_get('post_max_size') ?><br>
                        A request maximális mérete. Ebben benne van minden adat, de a fájlfeltöltésnél van jelentősége.
                        Ha egy űrlapon csoportos fájlfeltöltés is megengedett, vagy egy űrlapon belül több file típusú input is van,
                        akkor az ezekben kiválasztott összes fájl együttes mérete nem haladhatja meg ezt a korlátot.
                    </p>
                    <p>
                        <a href = "https://www.php.net/manual/en/ini.core.php#ini.upload-max-filesize" target = "_blank" class = "font-weight-bold text-dark">upload_max_filesize</a>:
                        <?= ini_get('upload_max_filesize') ?><br>
                        A php-ban fájlonként is lehet maximalizálni az elfogadható méretet, ez az adat a megengedett legnagyobb fájlméret.
                        Ez a hiba nem okoz 0. soros hibát, de az ilyen fájlról csak adatokat tart meg a php a $_FILES tömbben, magát a fájlt eldobja.
                    </p>
                    <p>
                        <a href = "https://www.php.net/manual/en/ini.core.php#ini.max-file-uploads" target = "_blank" class = "font-weight-bold text-dark">max_file_uploads</a>:
                        <?= ini_get('max_file_uploads') ?> db<br>
                        Az egy request során feltölthető fájlok maximális mennyisége.
                    </p>
                    <hr>
                    <p>
                        Érdekesség, de van hasonló limit a $_GET, $_POST és $_COOKIE tömbök esetén is.
                        A rendszer a jelenlegi php.ini beállítások mellett <?= ini_get('max_input_vars') ?> db adatot képes fogadni
                        (<a href = "https://www.php.net/manual/en/info.configuration.php#ini.max-input-vars" target = "_blank">max_input_vars</a>).
                        A $_GET lehetséges mérete böngésző-függő is, hiszen ezt egyben az url hossza is korlátozza. Max 2000 karakteres url-t minden böngésző kezel
                        (ld: <a href = "https://stackoverflow.com/questions/417142/what-is-the-maximum-length-of-a-url-in-different-browsers" target = "_blank">stackoverflow</a>).
                        Ezek elég tág határok, erre nem szoktunk a böngészőben ellenőrzést végezni.
                    </p>
                </div>
            </div>
        </div>
        <div class = "tab-pane fade" id = "statusbar-tab-content-cookie">
            <?php if (empty($_COOKIE)): ?>
                <p class = "text-center m-5">A $_COOKIE üres.</p>
            <?php else: ?>
                <table class = "table table-bordered table-hover m-0">
                    <?php foreach ($_COOKIE as $key => $value): ?>
                        <tr>
                            <td class = "w-25"><strong><?= $key ?></strong></td>
                            <td>
                                <pre class = "mb-0"><?= filter_input(INPUT_COOKIE, $key, FILTER_SANITIZE_SPECIAL_CHARS) ?></pre>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
        <div class = "tab-pane fade" id = "statusbar-tab-content-server">
            <?php if (empty($_SERVER)): ?>
                <p class = "text-center m-5">A $_SERVER üres.</p>
            <?php else: ?>
                <table class = "table table-bordered table-hover m-0">
                    <?php foreach ($_SERVER as $key => $value): ?>
                        <tr>
                            <td class = "w-25"><strong><?= $key ?></strong></td>
                            <td>
                                <pre class = "mb-0"><?= $value ?></pre>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
        <div class = "tab-pane fade" id = "statusbar-tab-content-globals">
            <ul class = "nav nav-pills nav-fill">
                <li class = "nav-item m-2" title = "A $_GLOBALS tömbből lekérdezhető adatok">
                    <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-globals-globals">$_GLOBALS</a>
                </li>
                <li class = "nav-item m-2" title = "A $_REQUEST tömbből lekérdezhető adatok">
                    <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-globals-request">$_REQUEST</a>
                </li>
                <li class = "nav-item m-2" title = "Az $_ENV tömbből lekérdezhető környezeti változók a get_env() segítségével">
                    <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-globals-env">$_ENV</a>
                </li>
                <li class = "nav-item m-2" title = "A php.ini-ben rögzített környezeti változók">
                    <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-globals-php-info" id = "statusbar-tab-content-globals-php-info-show">phpInfo()</a>
                </li>
                <li class = "nav-item m-2" title = "Konstansok, amiket mi hoztunk létre">
                    <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-system-constants-user">Constants user</a>
                </li>
                <li class = "nav-item m-2" title = "A rendszerben elérhető összes konstans">
                    <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-system-constants-all">Constants all</a>
                </li>
                <li class = "nav-item m-2" title = "A betöltődött saját függvényeink listája">
                    <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-system-functions-user">Functions user</a>
                </li>
                <li class = "nav-item m-2" title = "A rendszerben elérhető összes függvény listája">
                    <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-system-functions-internal">Functions all</a>
                </li>
            </ul>
            <div class = "tab-content">
                <div class = "tab-pane fade" id = "statusbar-tab-content-globals-globals">
                    <?php if (empty($GLOBALS)): ?>
                        <p class = "text-center m-5">A $GLOBALS üres.</p>
                    <?php else: ?>
                        <table class = "table table-bordered table-hover m-0">
                            <?php foreach ($GLOBALS as $key => $value): ?>
                                <tr>
                                    <td class = "w-25"><strong><?= $key ?></strong></td>
                                    <td class = "text-wrap">
                                        <pre class = "mb-0"><?= var_export($value) ?></pre>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
                <div class = "tab-pane fade" id = "statusbar-tab-content-globals-request">
                    <?php if (empty($_REQUEST)): ?>
                        <p class = "text-center m-5">A $_REQUEST üres.</p>
                    <?php else: ?>
                        <table class = "table table-bordered table-hover m-0">
                            <?php foreach ($_REQUEST as $key => $value): ?>
                                <tr>
                                    <td class = "w-25"><strong><?= $key ?></strong></td>
                                    <td>
                                        <pre class = "mb-0"><?= var_export($value) ?></pre>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
                <div class = "tab-pane fade" id = "statusbar-tab-content-globals-env">
                    <?php if (empty($_ENV)): ?>
                        <p class = "text-center m-5">A $_ENV üres.</p>
                    <?php else: ?>
                        <table class = "table table-bordered table-hover m-0">
                            <?php foreach ($_ENV as $key => $value): ?>
                                <tr>
                                    <td class = "w-25"><strong><?= $key ?></strong></td>
                                    <td>
                                        <pre class = "mb-0"><?= var_export($value) ?></pre>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
                <div class = "tab-pane fade" id = "statusbar-tab-content-globals-php-info">
                    <iframe id = "statusbar-tab-content-globals-php-info-iframe" src = "<?= '/index/phpinfo' ?>"></iframe>
                </div>
                <div class = "tab-pane fade" id = "statusbar-tab-content-system-constants-user">
                    <?php $getDefinedConstants = get_defined_constants(true); ?>
                    <?php if (empty($getDefinedConstants) || !array_key_exists('user', $getDefinedConstants)): ?>
                        <p class = "text-center m-5">Nincsenek saját konstansok a rendszerben.</p>
                    <?php else: ?>
                        <table class = "table table-bordered table-hover m-0">
                            <?php foreach ($getDefinedConstants['user'] as $key => $value): ?>
                                <tr>
                                    <td class = "w-25"><strong><?= $key ?></strong></td>
                                    <td>
                                        <pre class = "mb-0"><?= var_export($value) ?></pre>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
                <div class = "tab-pane fade" id = "statusbar-tab-content-system-constants-all">
                    <?php if (empty($getDefinedConstants)): ?>
                        <p class = "text-center m-5">Nincsenek konstansok a rendszerben.</p>
                    <?php else: ?>
                        <table class = "table table-bordered table-hover m-0">
                            <?php foreach ($getDefinedConstants as $key => $value): ?>
                                <tr>
                                    <td class = "w-25"><strong><?= $key ?></strong></td>
                                    <td>
                                        <pre class = "mb-0"><?= var_export($value) ?></pre>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
                <div class = "tab-pane fade" id = "statusbar-tab-content-system-functions-user">
                    <?php $getDefinedFunctions = get_defined_functions(); ?>
                    <?php if (empty($getDefinedFunctions) || !array_key_exists('user', $getDefinedFunctions)): ?>
                        <p class = "text-center m-5">Nincsenek saját funkciók.</p>
                    <?php else: ?>
                        <table class = "table table-bordered table-hover m-0">
                            <?php foreach (get_defined_functions()['user'] as $key => $value): ?>
                                <tr>
                                    <td>
                                        <pre class = "mb-0"><?= $value ?></pre>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
                <div class = "tab-pane fade" id = "statusbar-tab-content-system-functions-internal">
                    <?php if (empty($getDefinedFunctions) || !array_key_exists('internal', $getDefinedFunctions)): ?>
                        <p class = "text-center m-5">Nincsenek saját funkciók.</p>
                    <?php else: ?>
                        <table class = "table table-bordered table-hover m-0">
                            <?php foreach ($getDefinedFunctions['internal'] as $key => $value): ?>
                                <tr>
                                    <td>
                                        <pre class = "mb-0"><?= $value ?></pre>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class = "tab-pane fade" id = "statusbar-tab-content-header">
            <ul class = "nav nav-pills nav-fill">
                <li class = "nav-item m-2" title = "A böngésző állítja össze, a $_SERVER tömbből lehet lekérdezni őket">
                    <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-header-request">Request header</a>
                </li>
                <li class = "nav-item m-2" title = "Vagy mi állítjuk be a header() függvénnyel, vagy a szerver adja automatikusan">
                    <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-header-response">Response header</a>
                </li>
            </ul>
            <div class = "tab-content">
                <div class = "tab-pane fade" id = "statusbar-tab-content-header-request">
                    <?php if (empty(apache_request_headers())): ?>
                        <p class = "text-center m-5">Hiba! A request header tartalma nem elérhető.</p>
                    <?php else: ?>
                        <table class = "table table-bordered table-hover m-0">
                            <?php foreach (apache_request_headers() as $key => $value): ?>
                                <tr>
                                    <td class = "w-25">
                                        <a href = "https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/<?= $key ?>" target = "_blank" class = "font-weight-bold text-dark">
                                            <?= $key ?>
                                        </a>
                                    </td>
                                    <td>
                                        <pre class = "mb-0"><?= $value ?></pre>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
                <div class = "tab-pane fade" id = "statusbar-tab-content-header-response">
                    <?php if (empty(apache_response_headers())): ?>
                        <p class = "text-center m-5">Hiba! A response header tartalma nem elérhető.</p>
                    <?php else: ?>
                        <table class = "table table-bordered table-hover m-0">
                            <?php foreach (apache_response_headers() as $key => $value): ?>
                                <tr>
                                    <td class = "w-25">
                                        <a href = "https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/<?= $key ?>" target = "_blank" class = "font-weight-bold text-dark">
                                            <?= $key ?>
                                        </a>
                                    </td>
                                    <td>
                                        <pre class = "mb-0"><?= $value ?></pre>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class = "tab-pane fade" id = "statusbar-tab-content-mysql-query">
            <?php if (!CustomStatementDebug::getInstance()->hasExecutedQuery()): ?>
                <p class = "text-center m-5">Nem volt adatbázisművelet.</p>
            <?php else: ?>
                <table class = "table table-bordered table-hover m-0">
                    <?php foreach (CustomStatementDebug::getInstance()->getAllQueries() as $executedQuery): ?>
                        <tr>
                            <td>
                                <pre class = "mb-0"><?= $executedQuery ?></pre>
                            </td>
                            <td class = "cell-clipboard-button">
                                <button type = "button" title = "Copy to clipboard"></button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endif; ?>
        </div>
        <div class = "tab-pane fade" id = "statusbar-tab-content-system">
            <?php $includedFiles = get_included_files() ?>
            <ul class = "nav nav-pills nav-fill">
                <li class = "nav-item m-2" title = "A rendszerbe betöltődött fájlok listája">
                    <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-system-included">Betöltött fájlok (<?= count($includedFiles) ?> db)</a>
                </li>
                <li class = "nav-item m-2" title = "A válasz elkészítéséhez szükséges idő és memória">
                    <a class = "nav-link p-3" data-toggle = "tab" href = "#statusbar-tab-content-memory">Erőforrásigény</a>
                </li>
            </ul>
            <div class = "tab-content">
                <div class = "tab-pane fade" id = "statusbar-tab-content-system-included">
                    <?php if (empty($includedFiles)): ?>
                        <p class = "text-center m-5">A get_included_files üres.</p>
                    <?php else: ?>
                        <table class = "table table-bordered table-hover m-0">
                            <?php foreach ($includedFiles as $key => $value): ?>
                                <tr>
                                    <td>
                                        <pre class = "mb-0"><?= $value ?></pre>
                                    </td>
                                    <td class = "w-25 text-right pr-5">
                                        <pre class = "mb-0"><?= number_format(filesize($value) / 1024, 3, ',', ' ') ?> Kb</pre>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                </div>
                <div class = "tab-pane fade" id = "statusbar-tab-content-memory">
                    <table class = "table table-bordered table-hover m-0">
                        <tr>
                            <td class = "w-25"><strong>Microtime:</strong></td>
                            <td>
                                <?= !empty($_SERVER['REQUEST_TIME_FLOAT']) ? number_format((microtime(true) - floatval($_SERVER['REQUEST_TIME_FLOAT'])), 6, ',', ' ') : '0' ?>
                                sec
                            </td>
                        </tr>
                        <tr>
                            <td class = "w-25"><strong>Pillanatnyilag használatban lévő memória:</strong></td>
                            <td>
                                <?= number_format(round(memory_get_usage() / 1048576, 2), 2, '.', ' ') . ' Mb (' . number_format(memory_get_usage(), 0, '.', ' ') . ' byte)' ?>
                            </td>
                        </tr>
                        <tr>
                            <td class = "w-25"><strong>A rendszerből kiosztott teljes memória:</strong></td>
                            <td>
                                <?= number_format(round(memory_get_usage(true) / 1048576, 2), 2, '.', ' ') . ' Mb (' . number_format(memory_get_usage(true), 0, '.', ' ') . ' byte)' ?>
                            </td>
                        </tr>
                        <tr>
                            <td class = "w-25"><strong>Memóriahasználat csúcsa:</strong></td>
                            <td>
                                <?= number_format(round(memory_get_peak_usage() / 1048576, 2), 2, '.', ' ') . ' Mb (' . number_format(memory_get_peak_usage(), 0, '.', ' ') . ' byte)' ?>
                            </td>
                        </tr>
                        <tr>
                            <td class = "w-25"><strong>A rendszerből kiosztott teljes memória csúcsa:</strong></td>
                            <td class = "font-weight-bold">
                                <?= number_format(round(memory_get_peak_usage(true) / 1048576, 2), 2, '.', ' ') . ' Mb (' . number_format(memory_get_peak_usage(true), 0, '.', ' ') . ' byte)' ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class = "tab-pane fade" id = "statusbar-tab-content-design-mode">
            <div class = "p-5">
                <div class = "custom-control custom-switch mb-3">
                    <input type = "checkbox"
                           class = "custom-control-input"
                           id = "statusbar-tab-content-design-mode-editor">
                    <label class = "custom-control-label" for = "statusbar-tab-content-design-mode-editor">Editor mód</label>
                </div>
                <div class = "custom-control custom-switch mb-3">
                    <input type = "checkbox"
                           class = "custom-control-input"
                           id = "statusbar-tab-content-design-mode-background">
                    <label class = "custom-control-label" for = "statusbar-tab-content-design-mode-background">Háttér hozzáadása</label>
                </div>
                <div class = "custom-control custom-switch mb-3">
                    <input type = "checkbox"
                           class = "custom-control-input"
                           id = "statusbar-tab-content-design-mode-border">
                    <label class = "custom-control-label" for = "statusbar-tab-content-design-mode-border">Keret hozzáadása</label>
                </div>
                <div class = "mb-3">
                    <p>
                        További hasonló CSS debug ötletek a
                        <a href = "https://css-tricks.com/web-development-bookmarklets/" target = "_blank">https://css-tricks.com/</a>
                        oldalon találhatók.
                    </p>
                </div>
            </div>
        </div>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Gomb és panel kijelölése, létezésük ellenőrzése
        const btn = document.getElementById('statusbar-dropdown-button');
        if (!btn) throw new Error('A statusbar gombja nem elérhető. Hiányzó elem a DOM-ban id=statusbar-dropdown-button');
        const content = document.getElementById('statusbar-dropdown-content');
        if (!content) throw new Error('A statusbar dropdown content panel nem elérhető. Hiányzó elem a DOM-ban id=statusbar-dropdown-content');

        // Panel megjelenítése, rejtése gombnyomásra
        btn.addEventListener('click', function () {
            content.style.display = window.getComputedStyle(content).display === 'none' ? 'block' : 'none';
        });
        // Tervezési mód / Szerkesztő mód switch eseménykezelése
        const switchEditor = document.getElementById('statusbar-tab-content-design-mode-editor');
        if (switchEditor) switchEditor.addEventListener('change', function (e) {
            document.designMode = e.target.checked ? "on" : "off";
        });
        // Tervezési mód / Háttér hozzáadása switch eseménykezelése
        const switchBackground = document.getElementById('statusbar-tab-content-design-mode-background');
        if (switchBackground) switchBackground.addEventListener('change', function () {
            (function () {
                window.__CSSDebugBg__ = !window.__CSSDebugBg__;
                for (const element of document.querySelectorAll('*')) {
                    element.style.background = window.__CSSDebugBg__ ? "rgb(0 0 0 / 10%)" : null
                }
            })();
        });
        // Tervezési mód / Keret hozzáadása switch eseménykezelése
        const switchBorder = document.getElementById('statusbar-tab-content-design-mode-border');
        if (switchBorder) switchBorder.addEventListener('change', function () {
            (function () {
                window.__CSSDebugBorder__ = !window.__CSSDebugBorder__;
                for (const element of document.querySelectorAll('*')) {
                    element.style.outline = window.__CSSDebugBorder__ ? "solid hsl(" + 9 * (element + element).length + ",99%,50%)1px" : null;
                }
            })();
        });
        // Phpinfo iframe panel méretezése
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            if (e.target.id === 'statusbar-tab-content-globals-php-info-show') {
                const iframe = document.getElementById('statusbar-tab-content-globals-php-info-iframe');
                if (iframe) {
                    iframe.style.height = content.scrollHeight + 'px';
                    iframe.style.width = content.scrollWidth + 'px';
                    iframe.style.border = 'none';
                }
            }
        });

        // Vágólapra másolás kezelése
        const copyToClipboard = function (e) {

            // A függvény a gomb sorában lévő <pre> tag tartalmát helyezi a vágólapra

            // Elemek kijelölése
            const tr = e.target.closest('tr');
            if (!tr) throw new Error('A vágólap gombjának sora nem elérhető.');
            const pre = tr.querySelector('pre');
            if (!tr) throw new Error('A vágólap gombjának sorában lévő pre tag nem elérhető.');
            const btn = tr.querySelector('button');
            if (!btn) throw new Error('A vágólap gombjának sorában lévő button tag nem elérhető.');

            // Összes gomb eredeti dizájnjának helyreállítása
            for (const button of document.querySelectorAll('#statusbar-dropdown-content .cell-clipboard-button button')) {
                button.style.color = 'black';
                button.style.backgroundColor = 'black';
                button.style.mask = 'url(/assets/svg/Clipboard.svg) no-repeat center';
                button.style.webkitMask = 'url(/assets/svg/Clipboard.svg) no-repeat center';
            }

            // Vágólaprekord készítése
            const text = pre.innerText;
            const type = "text/plain";
            const blob = new Blob([text], {type});
            const data = [new ClipboardItem({[type]: blob})];

            // Vágólapra másolás, majd success és error kezelés
            navigator.clipboard.write(data).then(
                () => {
                    btn.style.color = 'green';
                    btn.style.backgroundColor = 'green';
                    btn.style.mask = 'url(/assets/svg/ClipboardOk.svg) no-repeat center';
                    btn.style.webkitMask = 'url(/assets/svg/ClipboardOk.svg) no-repeat center';
                },
                () => {
                    btn.style.color = 'red';
                    btn.style.backgroundColor = 'red';
                    btn.style.mask = 'url(/assets/svg/ClipboardNo.svg) no-repeat center';
                    btn.style.webkitMask = 'url(/assets/svg/ClipboardNo.svg) no-repeat center';
                },
            );
        }
        for (const btn of document.querySelectorAll('#statusbar-dropdown-content .cell-clipboard-button button')) {
            btn.addEventListener('click', copyToClipboard);
        }

        btn.classList.add('show');
        console.log('%c A statusbar betöltődött ', 'color:white; background:darkgrey; padding: .1rem');
    });
</script>
