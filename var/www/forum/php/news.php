<?php
  include("parsedown.php");
  $parsedown = new Parsedown();
  foreach (glob(getcwd() . "/data/news/*.md") as $news_entry)
  {
    $fdata = stat($news_entry);
    $pathinfo = pathinfo($news_entry);
?>
    <div class="news-entry framed">
       <h3><?= $pathinfo["filename"]; ?></h3>
       <div class="news-entry-meta">
        <p>Last Updated: <time datatime="<?= date(DATE_W3C, $fdata[9]); ?>"><?= date(DATE_W3C, $fdata[9]); ?></time></p>
      </div>
      <?= $parsedown->text(file_get_contents($news_entry)); ?>
    </div>
<?php
  }
?>
