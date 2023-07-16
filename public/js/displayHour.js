let dateInput = document.querySelector("#reservation_form_date");
let hourInput = document.querySelector("#reservation_form_hour");
let hourLabel = document.querySelector("#my-label-id");

hourInput.style.display = "none";
hourLabel.style.display = "none";

dateInput.addEventListener("input", function() {
  if (dateInput.value.trim() !== "") {
    hourInput.style.display = "";
    hourLabel.style.display = "";
  } else {
    hourInput.style.display = "none";
    hourLabel.style.display = "none";
  }
});
