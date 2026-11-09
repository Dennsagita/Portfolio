document.addEventListener("DOMContentLoaded", function() {
  const form = document.getElementById("contact_form");
  const successDiv = form.querySelector(".success");
  const emptyNotice = form.querySelector(".empty_notice");

  form.addEventListener("submit", function(e) {
    e.preventDefault();

    const name = form.querySelector(".name").value.trim();
    const email = form.querySelector(".email").value.trim();
    const tel = form.querySelector(".tel").value.trim();
    const message = form.querySelector(".message").value.trim();
    const toEmail = form.getAttribute("data-email");

    successDiv.style.display = "none";
    emptyNotice.style.display = "none";

    if (!name || !email || !message) {
      emptyNotice.style.display = "block";
      return;
    }

    fetch("php/send_email.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ name, email, tel, message, toEmail })
    })
    .then(response => response.text())
    .then(data => {
      successDiv.textContent = data;
      successDiv.style.display = "block";
      form.reset();
    })
    .catch(error => {
      successDiv.textContent = "Something went wrong. Please try again later.";
      successDiv.style.display = "block";
      console.error("Error:", error);
    });
  });
});