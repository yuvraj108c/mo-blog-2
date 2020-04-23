window.onscroll = () => {
  const btn = document.getElementById("scroll-to-top");
  const progressBar = document.getElementById("progress");

  const winScroll =
    document.body.scrollTop || document.documentElement.scrollTop;
  const height =
    document.documentElement.scrollHeight -
    document.documentElement.clientHeight;
  const scrolled = (winScroll / height) * 100;

  progressBar.style.width = `${scrolled}%`;

  if (winScroll > 50) {
    btn.style.display = "block";
    btn.onclick = scrollToTop;
  } else {
    btn.style.display = "none";
  }
};

function scrollToTop() {
  window.scroll({ top: 0, left: 0, behavior: "smooth" });
}
