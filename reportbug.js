function captchaResize() {
  var captchaCodeWidth = document.getElementById("bugkiller-captcha-code").offsetWidth;
  document.getElementById("captcha").style.width = captchaCodeWidth + "px";
  document.getElementById("captcha").classList.add("bugkiller-captcha-input-modified");
}
