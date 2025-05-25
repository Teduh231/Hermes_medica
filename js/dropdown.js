const dropdownTrigger = document.querySelector(
  ".user-dropdown .dropdown-trigger"
);
const dropdownContent = document.querySelector(
  ".user-dropdown .dropdown-content"
);

if (dropdownTrigger && dropdownContent) {
  dropdownTrigger.addEventListener("click", () => {
    dropdownContent.classList.toggle("show");
  });

  window.addEventListener("click", (event) => {
    if (
      !dropdownContent.contains(event.target) &&
      !dropdownTrigger.contains(event.target)
    ) {
      dropdownContent.classList.remove("show");
    }
  });
}
function toggleDropdown(event, trigger) {
  event.preventDefault();

  document.querySelectorAll(".dropdown").forEach(function (drop) {
    if (drop !== trigger.parentElement) {
      drop.classList.remove("open");
    }
  });

  trigger.parentElement.classList.toggle("open");
}

document.addEventListener("click", function (e) {
  if (!e.target.closest(".dropdown")) {
    document.querySelectorAll(".dropdown").forEach(function (drop) {
      drop.classList.remove("open");
    });
  }
});
