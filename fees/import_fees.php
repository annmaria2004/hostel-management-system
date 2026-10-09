<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Import Fees</title>

    <link rel="stylesheet"
          href="../assets/css/style.css">

</head>

<body>

<div class="container">

    <div class="page-header">

        <div>
            <h1>Import Fees</h1>
            <p>Import fee records from an Excel file</p>
        </div>

        <a href="fee_list.php"
           class="btn btn-secondary">

            Back

        </a>

    </div>


    <div class="card">

        <div class="alert alert-warning">

            <strong>Note:</strong>

            Upload an Excel file containing the fee records.

        </div>


        <form action="#" method="POST"
              enctype="multipart/form-data">

            <div class="file-upload">

                <h3>
                    Upload Excel File
                </h3>

                <p style="margin-top: 10px; color: #777;">
                    Supported formats: .xlsx, .xls
                </p>

                <input
                    type="file"
                    name="fee_file"
                    accept=".xlsx,.xls"
                    required>

            </div>


            <div class="form-actions">

                <button
                    type="submit"
                    class="btn btn-primary">

                    Upload & Import

                </button>

                <a
                    href="fee_list.php"
                    class="btn btn-secondary">

                    Cancel

                </a>

            </div>

        </form>

    </div>


    <!-- Excel Format -->

    <div class="card">

        <h2 style="margin-bottom: 15px;">
            Expected Excel Columns
        </h2>

        <table>

            <thead>

                <tr>
                    <th>user_id</th>
                    <th>amount</th>
                    <th>paid_date</th>
                    <th>due_date</th>
                    <th>status</th>
                </tr>

            </thead>

            <tbody>

                <tr>
                    <td>1</td>
                    <td>20000</td>
                    <td>-</td>
                    <td>2026-11-10</td>
                    <td>pending</td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

</body>

</html>