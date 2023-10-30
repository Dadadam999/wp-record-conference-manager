
<div class="container">
    <h1 class="h3 text-center my-5">Импортировать мероприятия из файла</h1>

    <div style=" max-width: 500px; margin: 0px auto; padding: 10px">
        <span>Создайте csv файл (разделитель ;) в кодировке utf8 с полями в шапке:</span>
        <pre>title, event_id, hall, speaker, number, symposium, start_date, end_date, url</pre>
        <span>Пример шорткода для вставки:</span>
        <pre>[conference_list event_id="123"]</pre>
    </div>

    <div style=" max-width: 500px; margin: 0px auto;">
        <form action="" method="post" enctype="multipart/form-data">
            <?php wp_nonce_field( $this->nonce['action'], $this->nonce['name'] ); ?>
            <input type="file" id="rcm-import-file" name="rcm-import-file">
            <br><br>
            <button type="submit" style="margin-top:20px;" class="button button-primary">Импортировать файл</button>
        </form>
    </div>
</div>
