function unhideReply() {
  const reply = document.getElementById("reply");
  const spacer = document.getElementById("spacer");
  spacer.style.display = "block";
  reply.style.display = "block";
  const height = reply.getBoundingClientRect().height;
  spacer.style.height = `${height}px`;
  window.scrollBy(0, height);
}

function hideReply() {
  const reply = document.getElementById("reply");
  const spacer = document.getElementById("spacer");
  spacer.style.display = "none";
  reply.style.display = "none";
}

function toggleReply() {
  const reply = document.getElementById("reply");
  if (reply.style.display === "none")
  {
    unhideReply();
  }
  else
  {
    hideReply();
  }
}
