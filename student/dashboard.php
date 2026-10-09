<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Student Dashboard</title>

    <link rel="stylesheet"
          href="../assets/css/style.css">

</head>

<body>

<div class="container">

    <!-- ========================= -->
    <!-- DASHBOARD HEADER -->
    <!-- ========================= -->

    <div class="page-header">

        <div>

            <h1>Student Dashboard</h1>

            <p>
                Welcome back, Ann Maria
            </p>

        </div>


        <!-- Notification Bell -->

        <div class="notification-wrapper">

            <a href="notifications.php"
               class="notification-bell">

                🔔

                <span class="notification-count">
                    2
                </span>

            </a>

        </div>

    </div>


    <!-- ========================= -->
    <!-- WELCOME SECTION -->
    <!-- ========================= -->

    <div class="card dashboard-welcome">

        <h2>Welcome, Ann Maria!</h2>

        <p>
            Here is your hostel information and recent updates.
        </p>

    </div>


    <!-- ========================= -->
    <!-- DASHBOARD CARDS -->
    <!-- ========================= -->

    <div class="dashboard-grid">


        <!-- Room -->

        <div class="dashboard-card">

            <h3>Room</h3>

            <div class="dashboard-value">
                Room 204
            </div>

            <p>
                First Floor
            </p>

        </div>


        



        <!-- Fee -->

        <div class="dashboard-card">

            <h3>Fee Status</h3>

            <div class="dashboard-value fee-pending">
                Pending
            </div>

            <p>
                ₹20,000
            </p>

        </div>


    </div>


    <!-- ========================= -->
    <!-- RECENT NOTIFICATIONS -->
    <!-- ========================= -->

    <div class="card">

        <div class="notification-header">

            <h2>Recent Notifications</h2>

            <a href="notifications.php">
                View All
            </a>

        </div>


        <!-- Notification 1 -->

        <div class="notification-item">

            <div class="notification-icon">
                ⚠️
            </div>

            <div class="notification-content">

                <h3>
                    Fee Payment Due
                </h3>

                <p>
                    Your hostel fee of ₹20,000
                    is due on 10-11-2026.
                </p>

                <span class="notification-date">
                    Today
                </span>

            </div>

        </div>


        <!-- Notification 2 -->

        <div class="notification-item">

            <div class="notification-icon">
                🔔
            </div>

            <div class="notification-content">

                <h3>
                    Payment Reminder
                </h3>

                <p>
                    Please complete your pending
                    fee payment.
                </p>

                <span class="notification-date">
                    Yesterday
                </span>

            </div>

        </div>


    </div>


</div>

</body>

</html>