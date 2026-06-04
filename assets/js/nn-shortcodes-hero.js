(function () {
  if (typeof gsap === "undefined") {
    return;
  }

  var prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  if (prefersReducedMotion) {
    return;
  }

  document.querySelectorAll(".nn-hero").forEach(function (root) {
    var track = root.querySelector(".nn-hero__orbit-track");
    if (!track) {
      return;
    }

    var duration = parseFloat(root.getAttribute("data-duration")) || 28;
    var items = track.querySelectorAll(".nn-hero__orbit-item");

    gsap.to(track, {
      rotation: 360,
      duration: duration,
      ease: "none",
      repeat: -1,
    });

    items.forEach(function (item) {
      var img = item.querySelector("img");
      if (!img) {
        return;
      }

      var startAngle = parseFloat(item.style.getPropertyValue("--angle")) || 0;
      gsap.set(img, { rotation: -startAngle });
      gsap.to(img, {
        rotation: -startAngle - 360,
        duration: duration,
        ease: "none",
        repeat: -1,
      });
    });
  });
})();
