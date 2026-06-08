(function () {
  var prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
  var GUY_ENTRANCE_DURATION = 1.05;
  var GUY_ENTRANCE_DELAY_DEFAULT = 0.6;
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

  function whenHeroVisible(root, callback) {
    if (prefersReducedMotion || !("IntersectionObserver" in window)) {
      callback();
      return;
    }

    if (root.getBoundingClientRect().top < window.innerHeight && root.getBoundingClientRect().bottom > 0) {
      callback();
      return;
    }

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) {
            return;
          }

          observer.disconnect();
          callback();
        });
      },
      {
        threshold: 0.12,
        rootMargin: "0px 0px -5% 0px",
      }
    );

    observer.observe(root);
  }

  document.querySelectorAll(".nn-hero").forEach(function (root) {
    var track = root.querySelector(".nn-hero__orbit-track");
    var guy = root.querySelector(".nn-hero__guy");
    var duration = parseFloat(root.getAttribute("data-duration")) || 28;
    var guyDelay = parseFloat(root.getAttribute("data-guy-delay"));

    if (isNaN(guyDelay)) {
      guyDelay = GUY_ENTRANCE_DELAY_DEFAULT;
    }

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
      parseFloat(styles.getPropertyValue("--nn-hero-guy-rest-y")) || -13;

    function setGuyStartPosition() {
      var height = guy.offsetHeight || guy.naturalHeight;

      if (!height) {
        return false;
      }

      var restPx = (guyRestY / 100) * height;
      var startPx = restPx + height;

      gsap.set(guy, {
        xPercent: -guyCenterX,
        y: startPx,
        immediateRender: true,
      });

      return true;
    }

    function animateGuyEntrance() {
      if (prefersReducedMotion) {
        guy.classList.add("nn-hero__guy--no-motion");
        return;
      }

      if (!setGuyStartPosition()) {
        guy.classList.add("nn-hero__guy--animated");
        return;
      }

      var height = guy.offsetHeight || guy.naturalHeight;
      var restPx = (guyRestY / 100) * height;

      gsap.killTweensOf(guy);
      gsap.to(guy, {
        xPercent: -guyCenterX,
        y: restPx,
        duration: GUY_ENTRANCE_DURATION,
        delay: guyDelay,
        ease: "power2.out",
        onComplete: function () {
          guy.classList.add("nn-hero__guy--animated");
        },
      });
    }

    whenGuySized(guy, function () {
      if (!prefersReducedMotion) {
        setGuyStartPosition();
      }

      whenHeroVisible(root, animateGuyEntrance);
    });
  });
})();
