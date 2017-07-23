<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Akina
 */

 ?>

<!DOCTYPE html>
　　<meta name="viewport" content="width=device-width, initial-scale=1" />
<html>
<meta charset="UTF-8">
<title>ページは存在しません</title>
<div align="center" style='font-family:"微软雅黑"'>
<img src="<?php bloginfo('template_url'); ?>/images/404.jpg" border="0" height="" />
<br>
このページには、ああ見つけることができません!<br><br>

<div id="404bgm" style="display: none">
<audio src="<?php bloginfo('template_url'); ?>/images/404.mp3" controls="controls">
  <audio autoplay="autoplay"><source src="<?php bloginfo('template_url'); ?>/images/404.mp3" type="audio/mpeg" /></audio> <a target="_blank" href="/"></a>
</audio>
</div>

</div>
</div>
</footer>
</html>
