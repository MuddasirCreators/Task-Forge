<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Reset Password - TaskForge</title>

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
           MAIN WRAPPER
           ===================================================== */

        .reset-wrapper {

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

        .reset-left {

            width: 50%;
            height: 100vh;

            flex: 0 0 50%;

            margin: 0;
            padding: 0;

            overflow: hidden;

            background: #071318;
        }

        .reset-left img {

            width: 100%;
            height: 100%;

            display: block;

            object-fit: fill;

            object-position: center;
        }


        /* =====================================================
           RIGHT SIDE
           ===================================================== */

        .reset-right {

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

        .reset-card {

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

        .reset-content {

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

            color: #ffffff;
        }


        /* =====================================================
           MAIN ICON
           ===================================================== */

        .reset-icon-wrap {

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

        .reset-icon {

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

        .reset-header {

            text-align: center;

            margin-bottom: 17px;
        }

        .reset-header h1 {

            margin-bottom: 7px;

            color: #101828;

            font-size: 30px;

            font-weight: 800;

            letter-spacing: -.8px;
        }

        .reset-header h1 span {

            color: #079b5a;
        }

        .reset-header p {

            max-width: 450px;

            margin: auto;

            color: #667085;

            font-size: 13px;

            line-height: 1.6;
        }


        /* =====================================================
           STEPS
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

            background: rgba(255,255,255,.90);
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
           COMPLETED STEP
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
           ACTIVE RESET STEP
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
           STEP LINE
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
           FORM CARD
           ===================================================== */

        .reset-form {

            width: 100%;

            padding: 20px;

            border: 1px solid #dfe7e3;

            border-radius: 16px;

            background: #ffffff;

            box-shadow:
                0 14px 35px rgba(16,24,40,.06);
        }


        /* =====================================================
           FORM INTRO
           ===================================================== */

        .form-intro {

            display: flex;

            align-items: center;

            gap: 10px;

            margin-bottom: 15px;
        }

        .form-intro-icon {

            width: 38px;
            height: 38px;

            flex: 0 0 38px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 11px;

            background: #eaf9f2;

            color: #079b5a;

            font-size: 17px;
        }

        .form-intro-text strong {

            display: block;

            color: #1d2939;

            font-size: 13px;
        }

        .form-intro-text span {

            display: block;

            margin-top: 2px;

            color: #8a96a3;

            font-size: 10.5px;
        }


        /* =====================================================
           FORM GROUP
           ===================================================== */

        .form-group {

            margin-bottom: 13px;
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

        .password-input {

            width: 100%;

            height: 48px;

            padding:
                0 45px 0 44px;

            border: 1px solid #cfd7df;

            border-radius: 10px;

            outline: none;

            background: #ffffff;

            color: #172033;

            font-family: inherit;

            font-size: 13px;
        }

        .password-input:focus {

            border-color: #08a861;

            box-shadow:
                0 0 0 4px rgba(8,168,97,.09);
        }


        /* =====================================================
           SHOW/HIDE PASSWORD
           ===================================================== */

        .toggle-password {

            position: absolute;

            right: 13px;

            top: 50%;

            transform: translateY(-50%);

            width: 28px;
            height: 28px;

            display: flex;

            align-items: center;
            justify-content: center;

            border: 0;

            background: transparent;

            color: #8a96a3;

            cursor: pointer;

            font-size: 15px;
        }

        .toggle-password:hover {

            color: #079b5a;
        }


        /* =====================================================
           PASSWORD HINT
           ===================================================== */

        .password-hint {

            margin-top: 5px;

            color: #98a2b3;

            font-size: 10px;

            line-height: 1.4;
        }


        /* =====================================================
           ERROR
           ===================================================== */

        .field-error {

            display: block;

            margin-top: 5px;

            color: #dc2626;

            font-size: 10.5px;
        }


        /* =====================================================
           RESET BUTTON
           ===================================================== */

        .reset-button {

            width: 100%;

            height: 50px;

            margin-top: 4px;

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
           BACK LOGIN
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
           SECURITY BOX
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


        /* =====================================================
           MOBILE
           ===================================================== */

        @media (max-width: 900px) {

            body {
                overflow-y: auto;
            }

            .reset-wrapper {

                height: auto;

                min-height: 100vh;

                padding: 0;

                flex-direction: column;
            }

            .reset-left {

                width: 100%;

                height: 300px;

                flex: none;
            }

            .reset-right {

                width: 100%;

                height: auto;

                flex: none;
            }

            .reset-card {

                height: auto;

                min-height: 600px;

                padding: 30px 20px;

                border: 0;
            }

        }

    </style>

</head>


<body>


<div class="reset-wrapper">


    {{-- =====================================================
         LEFT IMAGE
         ===================================================== --}}

    <div class="reset-left">

        <img
            src="{{ asset('images/forgot-password1.png') }}"
            alt="TaskForge Password Reset"
        >

    </div>


    {{-- =====================================================
         RIGHT SIDE
         ===================================================== --}}

    <div class="reset-right">

        <div class="reset-card">

            <div class="reset-content">


                {{-- =================================================
                     SECURITY BADGE
                     ================================================= --}}

              


                {{-- =================================================
                     ICON
                     ================================================= --}}

                <div class="reset-icon-wrap">

                    <div class="reset-icon">

                        <i class="bi bi-key-fill"></i>

                    </div>

                </div>


                {{-- =================================================
                     HEADER
                     ================================================= --}}

                <div class="reset-header">

                    <h1>

                        Create your
                        <span>new password</span>

                    </h1>

                    <p>

                        Choose a strong new password for your
                        TaskForge account. Your old password
                        will no longer work after the reset.

                    </p>

                </div>


                {{-- =================================================
                     PROGRESS
                     ================================================= --}}

                <div class="recovery-steps">


                    {{-- EMAIL COMPLETED --}}

                    <div class="recovery-step completed">

                        <div class="step-number">

                            <i class="bi bi-check"></i>

                        </div>

                        Email

                    </div>


                    <div class="step-line completed"></div>


                    {{-- VERIFY COMPLETED --}}

                    <div class="recovery-step completed">

                        <div class="step-number">

                            <i class="bi bi-check"></i>

                        </div>

                        Verify

                    </div>


                    <div class="step-line completed"></div>


                    {{-- RESET ACTIVE --}}

                    <div class="recovery-step active">

                        <div class="step-number">

                            3

                        </div>

                        Reset

                    </div>


                </div>


                {{-- =================================================
                     RESET FORM
                     ================================================= --}}

                <form
                    method="POST"
                    action="{{ route('password.store') }}"
                    class="reset-form"
                >

                    @csrf


                    {{-- =================================================
                         TOKEN
                         ================================================= --}}

                    <input
    type="hidden"
    name="token"
    value="{{ $token }}"
>


                    {{-- =================================================
                         EMAIL
                         ================================================= --}}

                   <input
    type="hidden"
    name="email"
    value="{{ $email }}"
>


                    {{-- =================================================
                         INTRO
                         ================================================= --}}

                    <div class="form-intro">

                        <div class="form-intro-icon">

                            <i class="bi bi-lock-fill"></i>

                        </div>


                        <div class="form-intro-text">

                            <strong>
                                Set your new password
                            </strong>

                            <span>
                                Your password must be secure and easy
                                for you to remember.
                            </span>

                        </div>

                    </div>


                    {{-- =================================================
                         NEW PASSWORD
                         ================================================= --}}

                    <div class="form-group">

                        <label for="password">
                            New Password
                        </label>


                        <div class="input-wrapper">

                            <i
                                class="bi bi-lock input-icon"
                            ></i>


                            <input
                                id="password"
                                type="password"
                                name="password"
                                class="password-input"
                                placeholder="Enter your new password"
                                autocomplete="new-password"
                                required
                            >


                            <button
                                type="button"
                                class="toggle-password"
                                onclick="togglePassword(
                                    'password',
                                    this
                                )"
                                aria-label="Show password"
                            >

                                <i class="bi bi-eye"></i>

                            </button>

                        </div>


                        @error('password')

                            <span class="field-error">

                                {{ $message }}

                            </span>

                        @enderror


                        <div class="password-hint">

                            Use at least 8 characters with a
                            combination of letters, numbers and symbols.

                        </div>

                    </div>


                    {{-- =================================================
                         CONFIRM PASSWORD
                         ================================================= --}}

                    <div class="form-group">

                        <label for="password_confirmation">

                            Confirm New Password

                        </label>


                        <div class="input-wrapper">

                            <i
                                class="bi bi-shield-lock input-icon"
                            ></i>


                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                class="password-input"
                                placeholder="Confirm your new password"
                                autocomplete="new-password"
                                required
                            >


                            <button
                                type="button"
                                class="toggle-password"
                                onclick="togglePassword(
                                    'password_confirmation',
                                    this
                                )"
                                aria-label="Show password"
                            >

                                <i class="bi bi-eye"></i>

                            </button>

                        </div>


                        @error('password_confirmation')

                            <span class="field-error">

                                {{ $message }}

                            </span>

                        @enderror

                    </div>


                    {{-- =================================================
                         SUBMIT
                         ================================================= --}}

                    <button
                        type="submit"
                        class="reset-button"
                    >

                        <span>
                            Reset Password
                        </span>

                        <i class="bi bi-check2-circle"></i>

                    </button>


                </form>


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
                     SECURITY MESSAGE
                     ================================================= --}}

                <div class="security-box">

                    <div class="security-icon">

                        <i class="bi bi-shield-lock-fill"></i>

                    </div>


                    <div class="security-text">

                        <strong>
                            Your account is protected
                        </strong>

                        Your password is securely encrypted
                        and will never be visible to anyone.

                    </div>

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

function togglePassword(
    inputId,
    button
) {

    const input =
        document.getElementById(inputId);

    const icon =
        button.querySelector('i');


    if (input.type === 'password') {

        input.type = 'text';

        icon.classList.remove(
            'bi-eye'
        );

        icon.classList.add(
            'bi-eye-slash'
        );

        button.setAttribute(
            'aria-label',
            'Hide password'
        );

    } else {

        input.type = 'password';

        icon.classList.remove(
            'bi-eye-slash'
        );

        icon.classList.add(
            'bi-eye'
        );

        button.setAttribute(
            'aria-label',
            'Show password'
        );

    }

}


document.addEventListener(
    'DOMContentLoaded',
    function () {

        @if($errors->any())

            Swal.fire({

                icon: 'error',

                title: 'Password Reset Failed',

                text: @json($errors->first()),

                confirmButtonText: 'Try Again',

                confirmButtonColor: '#08a861',

                allowOutsideClick: false

            });

        @endif

    }
);

</script>


</body>

</html>