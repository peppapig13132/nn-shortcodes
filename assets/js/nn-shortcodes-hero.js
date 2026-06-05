(function () {
  var prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  var GUY_ENTRANCE_DURATION = 1.05;
  var GUY_ENTRANCE_DELAY = 0.15;
  var hasGsap = typeof gsap !== "undefined";

  function whenGuySized(guy, callback) {
    var attempts = 0;
    var maxAttempts = 60;

    function tryRun() {
      attempts += 1;

      if (guy.offsetHeight > 0) {
        callback();
        return;
      }

      if (attempts >= maxAttempts) {
        callback();
        return;
      }

      requestAnimationFrame(tryRun);
    }

    function afterDecode() {
      requestAnimationFrame(function () {
        requestAnimationFrame(tryRun);
      });
    }

    if (guy.complete && guy.naturalWidth > 0) {
      if (typeof guy.decode === "function") {
        guy.decode().then(afterDecode).catch(afterDecode);
      } else {
        afterDecode();
      }
      return;
    }

    guy.addEventListener("load", afterDecode, { once: true });
    guy.addEventListener("error", afterDecode, { once: true });
  }

  document.querySelectorAll(".nn-hero").forEach(function (root) {
    var track = root.querySelector(".nn-hero__orbit-track");
    var guy = root.querySelector(".nn-hero__guy");
    var duration = parseFloat(root.getAttribute("data-duration")) || 28;

    if (!hasGsap) {
      return;
    }

    if (track && !prefersReducedMotion) {
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
    }

    if (!guy) {
      return;
    }

    var styles = getComputedStyle(root);
    var guyCenterX =
      parseFloat(styles.getPropertyValue("--nn-hero-guy-center-x")) || 50;
    var guyRestY =
      parseFloat(styles.getPropertyValue("--nn-hero-guy-rest-y")) || -14;

    function animateGuyEntrance() {
      if (prefersReducedMotion) {
        guy.classList.add("nn-hero__guy--no-motion");
        return;
      }

      var height = guy.offsetHeight || guy.naturalHeight;

      if (!height) {
        guy.classList.add("nn-hero__guy--animated");
        return;
      }

      var restPx = (guyRestY / 100) * height;
      var startPx = restPx + height;

      gsap.killTweensOf(guy);
      gsap.fromTo(
        guy,
        {
          xPercent: -guyCenterX,
          y: startPx,
          immediateRender: true,
        },
        {
          xPercent: -guyCenterX,
          y: restPx,
          duration: GUY_ENTRANCE_DURATION,
          delay: GUY_ENTRANCE_DELAY,
          ease: "power2.out",
          onComplete: function () {
            guy.classList.add("nn-hero__guy--animated");
          },
        }
      );
    }

    whenGuySized(guy, animateGuyEntrance);
  });
})();
