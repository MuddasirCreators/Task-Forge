<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Forgot Password - TaskForge</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <link
        rel="icon"
        type="image/png"
        href="{{ asset('images/favicon.png') }}"
    >

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
        }

        body {
            overflow: hidden;
            font-family:
                Inter,
                "Segoe UI",
                Arial,
                sans-serif;
            background: #ffffff;
        }


        /* =====================================================
           MAIN
           ===================================================== */

        .forgot-wrapper {

            width: 100%;
            height: 100vh;

            display: flex;

            padding: 0 150px;

            gap: 0;

            overflow: hidden;
        }


        /* =====================================================
           LEFT IMAGE
           ===================================================== */

        .forgot-left {

            width: 50%;
            height: 100vh;

            flex: 0 0 50%;

            margin: 0;
            padding: 0;

            overflow: hidden;

            background: #071318;
        }

        .forgot-left img {

            width: 100%;
            height: 100%;

            display: block;

            object-fit: fill;

            object-position: center;
        }


        /* =====================================================
           RIGHT
           ===================================================== */

        .forgot-right {

            width: 50%;
            height: 100vh;

            flex: 0 0 50%;

            margin: 0;
            padding: 0;

            overflow: hidden;

            background: #f3f6f9;
        }


        /* =====================================================
           RIGHT CONTAINER
           ===================================================== */

        .forgot-card {

            width: 100%;
            height: 100%;

            padding: 30px 55px;

            display: flex;

            align-items: center;
            justify-content: center;

            overflow: hidden;

            background:
                radial-gradient(
                    circle at 90% 10%,
                    rgba(0, 194, 113, .10),
                    transparent 30%
                ),
                radial-gradient(
                    circle at 10% 90%,
                    rgba(0, 194, 113, .06),
                    transparent 28%
                ),
                #f3f6f9;

            border-top: 14px solid #000;
            border-right: 6px solid #000;
            border-bottom: 6px solid #000;
        }


        /* =====================================================
           CONTENT
           ===================================================== */

        .forgot-content {

            width: 100%;
            max-width: 510px;

            margin: auto;
        }


        /* =====================================================
           SECURITY BADGE
           ===================================================== */

        .security-badge {

            width: max-content;

            margin: 0 auto 15px;

            padding: 6px 12px 6px 7px;

            display: flex;
            align-items: center;

            gap: 8px;

            border: 1px solid #ccecdf;

            border-radius: 50px;

            background: #edfbf4;

            color: #078b53;

            font-size: 11px;
            font-weight: 700;
        }

        .security-badge-icon {

            width: 25px;
            height: 25px;

            display: flex;
            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #08a861;

            color: white;
        }


        /* =====================================================
           MAIN ICON
           ===================================================== */

        .forgot-icon-wrap {

            width: 70px;
            height: 70px;

            margin: 0 auto 15px;

            padding: 5px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 21px;

            background: #e1f8ec;

            box-shadow:
                0 12px 30px rgba(0, 145, 83, .12);
        }

        .forgot-icon {

            width: 100%;
            height: 100%;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 16px;

            background:
                linear-gradient(
                    135deg,
                    #0bc879,
                    #008e52
                );

            color: #ffffff;

            font-size: 25px;
        }


        /* =====================================================
           HEADER
           ===================================================== */

        .forgot-header {

            text-align: center;

            margin-bottom: 18px;
        }

        .forgot-header h1 {

            margin-bottom: 7px;

            color: #101828;

            font-size: 30px;

            font-weight: 800;

            letter-spacing: -.8px;
        }

        .forgot-header h1 span {

            color: #079b5a;
        }

        .forgot-header p {

            max-width: 450px;

            margin: auto;

            color: #667085;

            font-size: 13px;

            line-height: 1.6;
        }


        /* =====================================================
           PROGRESS
           ===================================================== */

        .recovery-steps {

            width: 100%;

            margin-bottom: 14px;

            padding: 9px 13px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            border: 1px solid #dfe7e3;

            border-radius: 12px;

            background: rgba(255,255,255,.85);
        }

        .recovery-step {

            display: flex;

            align-items: center;

            gap: 6px;

            color: #8b96a3;

            font-size: 10px;

            font-weight: 700;

            white-space: nowrap;
        }


        /* =====================================================
           ACTIVE STEP
           ===================================================== */

        .recovery-step.active {

            color: #008c54 !important;
        }

        .recovery-step.active .step-number {

            background: #08a861 !important;

            color: #ffffff !important;

            border-color: #08a861 !important;

            box-shadow:
                0 0 0 4px rgba(8,168,97,.12);
        }


        /* =====================================================
           COMPLETED
           ===================================================== */

        .recovery-step.completed {

            color: #078b53;
        }

        .recovery-step.completed .step-number {

            background: #08a861;

            color: #ffffff;

            border-color: #08a861;
        }


        /* =====================================================
           STEP NUMBER
           ===================================================== */

        .step-number {

            width: 23px;
            height: 23px;

            flex: 0 0 23px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #edf0f2;

            border: 1px solid #edf0f2;

            color: #7c8793;

            font-size: 9px;

            font-weight: 800;
        }


        /* =====================================================
           LINE
           ===================================================== */

        .step-line {

            flex: 1;

            height: 1px;

            margin: 0 8px;

            background: #dfe5e2;
        }

        .step-line.completed {

            background: #08a861;
        }


        /* =====================================================
           EMAIL FORM
           ===================================================== */

        .reset-form {

            width: 100%;

            padding: 20px;

            border: 1px solid #dfe5e5;

            border-radius: 16px;

            background: #ffffff;

            box-shadow:
                0 14px 35px rgba(16,24,40,.06);
        }

        .form-intro {

            display: flex;

            align-items: center;

            gap: 10px;

            margin-bottom: 15px;
        }

        .form-intro-icon {

            width: 36px;
            height: 36px;

            flex: 0 0 36px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 10px;

            background: #eaf9f2;

            color: #079b5a;
        }

        .form-intro-text strong {

            display: block;

            color: #1d2939;

            font-size: 12.5px;
        }

        .form-intro-text span {

            display: block;

            margin-top: 2px;

            color: #8a96a3;

            font-size: 10.5px;
        }


        /* =====================================================
           LABEL
           ===================================================== */

        .form-group {

            margin-bottom: 14px;
        }

        .form-group label {

            display: block;

            margin-bottom: 7px;

            color: #182230;

            font-size: 12.5px;

            font-weight: 700;
        }


        /* =====================================================
           INPUT
           ===================================================== */

        .input-wrapper {

            position: relative;
        }

        .input-icon {

            position: absolute;

            left: 15px;
            top: 50%;

            transform: translateY(-50%);

            color: #8c98a6;

            font-size: 16px;

            pointer-events: none;
        }

        .email-input {

            width: 100%;

            height: 50px;

            padding: 0 15px 0 44px;

            border: 1px solid #cfd7df;

            border-radius: 10px;

            outline: none;

            background: #ffffff;

            color: #172033;

            font-family: inherit;

            font-size: 13px;
        }

        .email-input:focus {

            border-color: #08a861;

            box-shadow:
                0 0 0 4px rgba(8,168,97,.09);
        }


        /* =====================================================
           SEND BUTTON
           ===================================================== */

        .reset-button {

            width: 100%;

            height: 50px;

            display: flex;

            align-items: center;
            justify-content: center;

            gap: 9px;

            border: 1px solid #007044;

            border-radius: 10px;

            background:
                linear-gradient(
                    135deg,
                    #08c978,
                    #009b59
                );

            color: #ffffff;

            font-family: inherit;

            font-size: 13.5px;

            font-weight: 750;

            cursor: pointer;

            box-shadow:
                0 9px 20px rgba(0,155,89,.20);
        }

        .reset-button:hover {

            transform: translateY(-1px);
        }


        /* =====================================================
           VERIFY CARD
           ===================================================== */

        .verify-card {

            width: 100%;

            padding: 25px 22px;

            border: 1px solid #cfe8da;

            border-radius: 17px;

            background:
                linear-gradient(
                    135deg,
                    #ffffff,
                    #f2fbf6
                );

            box-shadow:
                0 14px 35px rgba(16,24,40,.06);

            text-align: center;
        }

        .verify-icon {

            width: 65px;
            height: 65px;

            margin: 0 auto 14px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #d9f8e8;

            color: #079b5a;

            font-size: 28px;
        }

        .verify-card h2 {

            margin-bottom: 8px;

            color: #101828;

            font-size: 22px;

            font-weight: 800;
        }

        .verify-card h2 span {

            color: #079b5a;
        }

        .verify-card p {

            margin-bottom: 17px;

            color: #667085;

            font-size: 12.5px;

            line-height: 1.65;
        }

        .email-display {

            width: 100%;

            padding: 12px 15px;

            margin-bottom: 14px;

            display: flex;

            align-items: center;
            justify-content: center;

            gap: 9px;

            border: 1px solid #d5e7dc;

            border-radius: 10px;

            background: #f7fcf9;

            color: #087f52;

            font-size: 12px;

            font-weight: 700;

            word-break: break-word;
        }


        /* =====================================================
           GMAIL
           ===================================================== */

        .gmail-button {

            width: 100%;

            height: 48px;

            display: flex;

            align-items: center;
            justify-content: center;

            gap: 8px;

            border-radius: 10px;

            background:
                linear-gradient(
                    135deg,
                    #08c978,
                    #009b59
                );

            border: 1px solid #006f42;

            color: #ffffff;

            text-decoration: none;

            font-size: 13px;

            font-weight: 750;
        }


        /* =====================================================
           RESEND
           ===================================================== */

        .resend-button {

            width: 100%;

            height: 43px;

            margin-top: 9px;

            display: flex;

            align-items: center;
            justify-content: center;

            gap: 7px;

            border: 1px solid #d8dfe5;

            border-radius: 10px;

            background: #ffffff;

            color: #087f52;

            text-decoration: none;

            font-size: 12px;

            font-weight: 700;
        }


        /* =====================================================
           BACK
           ===================================================== */

        .back-login {

            width: 100%;

            height: 43px;

            margin-top: 10px;

            display: flex;

            align-items: center;
            justify-content: center;

            gap: 7px;

            border: 1px solid #d8dfe5;

            border-radius: 10px;

            background: #ffffff;

            color: #087f52;

            text-decoration: none;

            font-size: 12.5px;

            font-weight: 700;
        }


        /* =====================================================
           SECURITY
           ===================================================== */

        .security-box {

            width: 100%;

            margin-top: 11px;

            padding: 10px 13px;

            display: flex;

            align-items: center;

            gap: 10px;

            border: 1px solid #d7e9df;

            border-radius: 11px;

            background: #f3faf6;
        }

        .security-icon {

            width: 34px;
            height: 34px;

            flex: 0 0 34px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #d9f8e8;

            color: #078e54;
        }

        .security-text {

            color: #71808c;

            font-size: 10.5px;

            line-height: 1.4;
        }

        .security-text strong {

            display: block;

            color: #263443;

            font-size: 11.5px;
        }

        .recovery-note {

            margin-top: 8px;

            text-align: center;

            color: #98a2b3;

            font-size: 10px;
        }


        /* =====================================================
           MOBILE
           ===================================================== */

        @media (max-width: 900px) {

            body {
                overflow-y: auto;
            }

            .forgot-wrapper {

                height: auto;

                min-height: 100vh;

                padding: 0;

                flex-direction: column;
            }

            .forgot-left {

                width: 100%;

                height: 300px;

                flex: none;
            }

            .forgot-right {

                width: 100%;

                height: auto;

                flex: none;
            }

            .forgot-card {

                height: auto;

                min-height: 600px;

                padding: 30px 20px;

                border: 0;
            }

        }

    </style>

</head>


<body>


@php

    /*
    |--------------------------------------------------------------------------
    | CURRENT STEP
    |--------------------------------------------------------------------------
    |
    | Controller sends:
    |
    | /forgot-password?step=verify
    |
    | We read the query parameter directly.
    |
    */

    $currentStep = request()->query('step', 'email');

    $isVerifyStep =
        strtolower(trim($currentStep)) === 'verify';


    /*
    |--------------------------------------------------------------------------
    | EMAIL FROM SESSION
    |--------------------------------------------------------------------------
    */

    $resetEmail =
        session('reset_email')
        ?? old('email')
        ?? '';

@endphp


<div class="forgot-wrapper">


    {{-- =====================================================
         LEFT IMAGE
         ===================================================== --}}

    <div class="forgot-left">

        <img
            src="{{ asset('images/forgot-password1.png') }}"
            alt="TaskForge Forgot Password"
        >

    </div>


    {{-- =====================================================
         RIGHT SIDE
         ===================================================== --}}

    <div class="forgot-right">

        <div class="forgot-card">

            <div class="forgot-content">


                {{-- =================================================
                     SECURITY BADGE
                     ================================================= --}}

                <div style="display: none;" class="security-badge">

                    <div class="security-badge-icon">

                        <i class="bi bi-shield-check"></i>

                    </div>

                    Secure account recovery

                </div>


                {{-- =================================================
                     ICON
                     ================================================= --}}

                <div style="display: none;" class="forgot-icon-wrap">

              

                </div>


                {{-- =================================================
                     HEADER
                     ================================================= --}}

                @if($isVerifyStep)

                    <div class="forgot-header">

                        <h1>
                            Check your <span>email</span>
                        </h1>

                        <p>
                            Your password reset link has been
                            sent successfully. Check your Gmail
                            inbox to continue.
                        </p>

                    </div>

                @else

                    <div class="forgot-header">

                        <h1>
                            Forgot your <span>password?</span>
                        </h1>

                        <p>
                            No worries. Enter the email connected
                            to your TaskForge account and we'll
                            send you a secure password reset link.
                        </p>

                    </div>

                @endif


                {{-- =================================================
                     PROGRESS
                     ================================================= --}}

                <div class="recovery-steps">


                    {{-- EMAIL --}}

                    <div
                        class="
                            recovery-step
                            {{ $isVerifyStep
                                ? 'completed'
                                : 'active'
                            }}
                        "
                    >

                        <div class="step-number">

                            @if($isVerifyStep)

                                <i class="bi bi-check"></i>

                            @else

                                1

                            @endif

                        </div>

                        Email

                    </div>


                    {{-- LINE --}}

                    <div
                        class="
                            step-line
                            {{ $isVerifyStep
                                ? 'completed'
                                : ''
                            }}
                        "
                    ></div>


                    {{-- VERIFY --}}

                    <div
                        class="
                            recovery-step
                            {{ $isVerifyStep
                                ? 'active'
                                : ''
                            }}
                        "
                    >

                        <div class="step-number">
                            2
                        </div>

                        Verify

                    </div>


                    {{-- LINE --}}

                    <div class="step-line"></div>


                    {{-- RESET --}}

                    <div class="recovery-step">

                        <div class="step-number">
                            3
                        </div>

                        Reset

                    </div>


                </div>


                {{-- =================================================
                     VERIFY SCREEN
                     ================================================= --}}

                @if($isVerifyStep)

                    <div class="verify-card">


                        <div class="verify-icon">

                            <i class="bi bi-envelope-check-fill"></i>

                        </div>


                        <h2>

                            Reset link
                            <span>sent successfully!</span>

                        </h2>


                        <p>

                            We've sent a secure password reset
                            link to the email address below.

                            <br>

                            Please check your Gmail inbox and
                            spam folder, then click the reset link.

                        </p>


                        <div class="email-display">

                            <i class="bi bi-envelope-fill"></i>

                            {{ $resetEmail }}

                        </div>


                        <a
                            href="https://mail.google.com/"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="gmail-button"
                        >

                            <i class="bi bi-google"></i>

                            Check Gmail

                            <i class="bi bi-box-arrow-up-right"></i>

                        </a>


                        <a
                            href="{{ route('password.request') }}"
                            class="resend-button"
                        >

                            <i class="bi bi-arrow-repeat"></i>

                            Send reset link again

                        </a>


                    </div>


                @else


                    {{-- =================================================
                         EMAIL FORM
                         ================================================= --}}

                    <form
                        method="POST"
                        action="{{ route('password.email') }}"
                        class="reset-form"
                    >

                        @csrf


                        <div class="form-intro">

                            <div class="form-intro-icon">

                                <i class="bi bi-envelope-paper"></i>

                            </div>


                            <div class="form-intro-text">

                                <strong>
                                    Where should we send the link?
                                </strong>

                                <span>
                                    Use the email registered with TaskForge.
                                </span>

                            </div>

                        </div>


                        <div class="form-group">

                            <label for="email">
                                Email Address
                            </label>


                            <div class="input-wrapper">

                                <i
                                    class="bi bi-envelope input-icon"
                                ></i>


                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="email-input"
                                    placeholder="you@example.com"
                                    autocomplete="email"
                                    required
                                    autofocus
                                >

                            </div>


                            @error('email')

                                <span
                                    style="
                                        display:block;
                                        margin-top:5px;
                                        color:#dc2626;
                                        font-size:11px;
                                    "
                                >
                                    {{ $message }}
                                </span>

                            @enderror

                        </div>


                        {{-- =================================================
                             IMPORTANT:
                             NORMAL FORM SUBMIT
                             NO AJAX
                             NO PREVENTDEFAULT
                             NO FETCH
                             ================================================= --}}

                        <button
                            type="submit"
                            class="reset-button"
                        >

                            <span>
                                Send secure reset link
                            </span>

                            <i class="bi bi-send-fill"></i>

                        </button>


                    </form>

                @endif


                {{-- =================================================
                     BACK TO LOGIN
                     ================================================= --}}

                <a
                    href="{{ route('login') }}"
                    class="back-login"
                >

                    <i class="bi bi-arrow-left"></i>

                    Back to login

                </a>


                {{-- =================================================
                     SECURITY BOX
                     ================================================= --}}

                <div class="security-box">

                    <div class="security-icon">

                        <i class="bi bi-shield-lock-fill"></i>

                    </div>


                    <div class="security-text">

                        <strong>
                            Your information stays private
                        </strong>

                        We only use your email to send
                        the password recovery link.

                    </div>

                </div>


                <div class="recovery-note">

                    <i class="bi bi-lock-fill"></i>

                    Your password will never be sent by email.

                </div>


            </div>

        </div>

    </div>

</div>


{{-- =========================================================
     SWEETALERT
     ========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        /*
        |--------------------------------------------------------------------------
        | Laravel validation / mail errors
        |--------------------------------------------------------------------------
        */

        @if($errors->any())

            Swal.fire({

                icon: 'error',

                title: 'Unable to Send Reset Link',

                text: @json($errors->first()),

                confirmButtonText: 'Try Again',

                confirmButtonColor: '#ef4444',

                allowOutsideClick: false,

                allowEscapeKey: true

            });

        @endif


        /*
        |--------------------------------------------------------------------------
        | IMPORTANT
        |--------------------------------------------------------------------------
        |
        | There is intentionally NO:
        |
        | event.preventDefault()
        | fetch()
        | XMLHttpRequest
        | AJAX
        |
        | Laravel must receive the POST request normally.
        |
        */

    }
);

</script>


</body>

</html>