<script>
      document.addEventListener("DOMContentLoaded", function() {
            const rawHash = window.location.hash;

            if (rawHash.startsWith('#category-')) {
                  // Temporarily remove the hash to stop browser auto-scroll
                  history.replaceState(null, null, window.location.pathname);

                  const target = document.querySelector(rawHash);

                  if (target) {
                        // Wait a tick to allow layout to settle
                        setTimeout(() => {
                              const yOffset = -100; // Scroll offset from top (change as needed)
                              const y = target.getBoundingClientRect().top + window
                                    .pageYOffset + yOffset;

                              window.scrollTo({
                                    top: y,
                                    behavior: 'smooth'
                              });

                              // Add glow
                              target.classList.add('soft-shadow-glow');

                              target.addEventListener('animationend', () => {
                                    target.classList.remove('soft-shadow-glow');
                              });

                              // Restore the hash in URL (optional)
                              history.replaceState(null, null, window.location.pathname +
                                    rawHash);
                        }, 50);
                  }
            }
      });
</script>
