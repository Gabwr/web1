document.addEventListener("DOMContentLoaded", function () {
    const monthInput = document.getElementById("month");

    const savedMonth = localStorage.getItem("selectedMonth");
    if (savedMonth) {
        monthInput.value = savedMonth;
    }

    monthInput.addEventListener("change", function () {
        localStorage.setItem("selectedMonth", monthInput.value);
        window.location.href = "dashboard.php?month=" + monthInput.value;
    });
});