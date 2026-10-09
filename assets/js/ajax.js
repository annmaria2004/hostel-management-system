$(document).ready(function () {
    loadFees();
});
function loadFees() {

    $.ajax({

        url: "api/get_fees.php",

        type: "GET",

        dataType: "json",

        success: function (fees) {

            let rows = "";

            if (fees.length === 0) {

                rows = `
                    <tr>
                        <td colspan="7" style="text-align:center;">
                            No fee records found.
                        </td>
                    </tr>
                `;

            } else {

                $.each(fees, function (index, fee) {

                    let statusClass = "";

                    if (fee.status === "paid") {
                        statusClass = "status-paid";
                    } else {
                        statusClass = "status-pending";
                    }

                    let paidDate = fee.paid_date
                        ? fee.paid_date
                        : "-";

                    rows += `
                        <tr>

                            <td>${fee.fee_id}</td>

                            <td>${fee.name}</td>

                            <td>₹${fee.amount}</td>

                            <td>${paidDate}</td>

                            <td>${fee.due_date}</td>

                            <td>
                                <span class="status ${statusClass}">
                                    ${fee.status}
                                </span>
                            </td>

                            <td>

                                <a
                                    href="view_fee.php?id=${fee.fee_id}"
                                    class="action-btn btn-info">
                                    View
                                </a>

                                <a
                                    href="edit_fee.php?id=${fee.fee_id}"
                                    class="action-btn btn-warning">
                                    Edit
                                </a>

                                <a
                                    href="delete_fee.php?id=${fee.fee_id}"
                                    class="action-btn btn-danger">
                                    Delete
                                </a>

                            </td>

                        </tr>
                    `;

                });

            }

            $("#feeTableBody").html(rows);

        },

        error: function () {

            $("#feeTableBody").html(`
                <tr>
                    <td colspan="7" style="text-align:center;">
                        Unable to load fee records.
                    </td>
                </tr>
            `);

        }

    });

}