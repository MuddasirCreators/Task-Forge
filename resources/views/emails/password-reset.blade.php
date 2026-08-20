
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">

    <title>Password Reset - TaskForge</title>
</head>

<body style="
    margin:0;
    padding:0;
    background:#f3f6f9;
    color:#263642;
    font-family:Arial,Helvetica,sans-serif;
">

@php
    $name = $user->name ?? 'there';
    $resetLink = $resetUrl ?? url('/password/reset');

    // TaskForge Logo
    $logoUrl = 'https://i.ibb.co/Kx3QdnSc/favicon.png';
    $logoPage = 'https://ibb.co/yFbMt27m';
@endphp


<!-- OUTER EMAIL BACKGROUND -->
<table
    role="presentation"
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="
        width:100%;
        background:#f3f6f9;
        padding:20px 10px;
    "
>
    <tr>
        <td align="center">

            <!-- MAIN EMAIL CONTAINER -->
            <table
                role="presentation"
                width="480"
                cellpadding="0"
                cellspacing="0"
                border="0"
                style="
                    width:100%;
                    max-width:480px;
                    background:#ffffff;
                    border-radius:10px;
                    overflow:hidden;
                "
            >

                <!-- DARK HEADER -->
                <tr>
                    <td
                        style="
                            padding:18px 22px 22px;
                            background:#020b0a;
                            color:#ffffff;
                        "
                    >

                        <!-- LOGO - LEFT SIDE -->
                        <!-- <table
                            role="presentation"
                            width="100%"
                            cellpadding="0"
                            cellspacing="0"
                            border="0"
                        >
                            <tr>
                                <td align="left">

                                    <a
                                        href="{{ $logoPage }}"
                                        target="_blank"
                                        style="
                                            display:inline-block;
                                            text-decoration:none;
                                        "
                                    >
                                        <img
                                            src="{{ $logoUrl }}"
                                            alt="TaskForge"
                                            width="55"
                                            height="55"
                                            border="0"
                                            style="
                                                display:block;
                                                width:55px;
                                                height:55px;
                                                border:0;
                                                outline:none;
                                                text-decoration:none;
                                            "
                                        >
                                    </a>

                                </td>
                            </tr>
                        </table> -->


                        <!-- HEADER CONTENT -->
                        <div
                            style="
                                text-align:center;
                                margin-top:8px;
                            "
                        >

                            <!-- LOCK ICON -->
                            <div
                                style="
                                    width:46px;
                                    height:46px;
                                    margin:0 auto 11px;
                                    border:1px solid #00d084;
                                    border-radius:50%;
                                    background:#063b2d;
                                    color:#00d084;
                                    font-size:21px;
                                    line-height:46px;
                                    text-align:center;
                                "
                            >
                                &#128274;
                            </div>


                            <!-- TITLE -->
                            <h1
                                style="
                                    margin:0;
                                    padding:0;
                                    color:#ffffff;
                                    font-size:21px;
                                    line-height:27px;
                                    font-weight:700;
                                "
                            >
                                Password Reset Requested
                            </h1>


                            <!-- GREEN DIVIDER -->
                            <div
                                style="
                                    width:50px;
                                    height:2px;
                                    margin:10px auto;
                                    background:#00d084;
                                "
                            ></div>


                            <!-- DESCRIPTION -->
                            <p
                                style="
                                    margin:0;
                                    padding:0;
                                    color:#f2f5f5;
                                    font-size:12px;
                                    line-height:18px;
                                "
                            >
                                We received a request to reset the password
                                for your
                                <strong style="color:#00d084;">
                                    TaskForge
                                </strong>
                                account.
                            </p>

                        </div>

                    </td>
                </tr>


                <!-- MAIN CONTENT -->
                <tr>
                    <td
                        align="center"
                        style="
                            padding:25px 24px 27px;
                            background:#ffffff;
                        "
                    >

                        <!-- GREETING -->
                        <h2
                            style="
                                margin:0 0 8px;
                                padding:0;
                                color:#111820;
                                font-size:19px;
                                line-height:25px;
                                font-weight:700;
                            "
                        >
                            Hello {{ $name }},
                        </h2>


                        <!-- MESSAGE -->
                        <p
                            style="
                                margin:0;
                                padding:0;
                                color:#273746;
                                font-size:12px;
                                line-height:19px;
                            "
                        >
                            No worries! Click the button below to reset
                            your password.
                        </p>


                        <!-- EXPIRY -->
                        <p
                            style="
                                margin:4px 0 0;
                                padding:0;
                                color:#273746;
                                font-size:12px;
                                line-height:19px;
                            "
                        >
                            This password reset link expires in
                            <strong style="color:#009f63;">
                                15 minutes
                            </strong>.
                        </p>


                        <!-- RESET BUTTON -->
                        <table
                            role="presentation"
                            cellpadding="0"
                            cellspacing="0"
                            border="0"
                            align="center"
                            style="
                                margin:18px auto 18px;
                            "
                        >
                            <tr>
                                <td
                                    align="center"
                                    style="
                                        border-radius:6px;
                                        background:#00a968;
                                    "
                                >
                                    <a
                                        href="{{ $resetLink }}"
                                        target="_blank"
                                        style="
                                            display:inline-block;
                                            padding:10px 21px;
                                            color:#ffffff;
                                            font-size:12px;
                                            line-height:18px;
                                            font-weight:700;
                                            text-decoration:none;
                                            border-radius:6px;
                                        "
                                    >
                                        &#128274;&nbsp;
                                        Reset Password
                                        &nbsp;&#8594;
                                    </a>
                                </td>
                            </tr>
                        </table>


                        <!-- SECURITY MESSAGE -->
                        <p
                            style="
                                margin:0;
                                padding:0;
                                color:#52616b;
                                font-size:11px;
                                line-height:17px;
                            "
                        >
                            If you didn’t request a password reset,
                            <br>
                            you can safely ignore this email.
                        </p>

                    </td>
                </tr>


                <!-- FOOTER -->
                <tr>
                    <td
                        align="center"
                        style="
                            padding:13px 15px 15px;
                            background:#f5faf8;
                            border-top:1px solid #dce8e3;
                        "
                    >

                        <!-- FEATURES -->
                        <p
                            style="
                                margin:0 0 5px;
                                padding:0;
                                color:#009f63;
                                font-size:10px;
                                line-height:15px;
                            "
                        >
                            &#10003; Secure
                            &nbsp;&nbsp;&nbsp;
                            &#9711; Reliable
                            &nbsp;&nbsp;&nbsp;
                            &#8599; Productive
                        </p>


                        <!-- COPYRIGHT -->
                        <p
                            style="
                                margin:0;
                                padding:0;
                                color:#52616b;
                                font-size:10px;
                                line-height:15px;
                            "
                        >
                            &copy; {{ date('Y') }}

                            <strong style="color:#009f63;">
                                TaskForge
                            </strong>

                            . All rights reserved.
                        </p>

                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>

</body>
</html>

