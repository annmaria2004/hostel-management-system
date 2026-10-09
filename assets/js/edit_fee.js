
document.addEventListener("DOMContentLoaded", function () {
    const paidDate = document.getElementById("paid_date");
    const dueDate = document.getElementById("due_date");
    const form = document.getElementById("editFeeForm");

    if (!paidDate || !dueDate || !form) {
        return;
    }

    function validateDueDate() {
        dueDate.setCustomValidity("");

        if (
            paidDate.value &&
            dueDate.value &&
            dueDate.value < paidDate.value
        ) {
            dueDate.setCustomValidity(
                "Due Date cannot be earlier than Paid Date."
            );
        }
    }

    paidDate.addEventListener("change", validateDueDate);
    dueDate.addEventListener("change", validateDueDate);

    form.addEventListener("submit", function (event) {
        validateDueDate();

        if (!form.checkValidity()) {
            event.preventDefault();
            form.reportValidity();
        }
    });
});
