<div id="spacer" style="display: none;"></div>
<div id="reply" style="display:none;">
  <div class="framed">
    <button onclick="hideReply();">X</button>
    <p class="center">Reply</p>
    <form action="/php/sendmessage.php" method="post" enctype="multipart/form-data">
      <textarea name="text" rows="24" cols="120" required placeholder="Type your message..."></textarea><br />
      <input type="hidden" name="author_id" value="<?= $_SESSION["user_id"]; ?>" />
      <input type="hidden" name="topic_id" value="<?= urldecode($_GET["id"]); ?>" />
      <input type="submit" value="Send Message" />
    </form>
  </div>
</div>
