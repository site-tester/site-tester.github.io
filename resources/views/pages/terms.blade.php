@extends('layouts.app')

@section('title', 'Terms and Conditions')

@section('css')
    <script src="https://kit.fontawesome.com/be5b1ff12e.js" crossorigin="anonymous"></script>
@endsection

@section('background-color', 'bg-container')

@section('content')

    <div class="container w-50 m-auto">
        <div class="my-5">
            <h1 class="fw-bolder">Terms & Conditions</h1>
        </div>
        <h3 class="mb-3">Effective date: {{ $page->extras['effective_date'] }}</h3>
        <hr class="mb-3">
        <div class="terms card p-5">
            {{-- <h3 class="mb-2">1. Introduction</h3>
            <p class="px-3 mb-3">Welcome to the DisasterEase Web-Based In-Kind Donation System (the "System"). These terms
                and
                conditions govern your use of the System. By accessing or using the System, you agree to comply with these
                Terms. If you do not agree with any part of the Terms, please refrain from using the System.
            </p>

            <h3 class="mb-2">2. Definitions</h3>
            <p class="px-3 mb-3">
            <ul>
                <li>
                    <strong>System: </strong>
                    The DisasterEase platform for managing in-kind donations in Parañaque City.
                </li>
                <li>
                    <strong>User: </strong>
                    Any individual or organization accessing or using the System.
                </li>
                <li>
                    <strong>Donor: </strong>
                    Any User who submits donations through the System.
                </li>
                <li>
                    <strong>Barangay Admin: </strong>
                    Local government officials managing and approving donations.
                </li>
            </ul>

            </p>

            <h3 class="mb-2">3. Eligibility</h3>
            <p class="px-3 mb-3">The System is open to individuals aged 18 and above and legally established organizations.
                By registering, you affirm that you are eligible to make in-kind donations and are using the System in
                compliance with applicable laws.
            </p>

            <h3 class="mb-2">4. User Accounts</h3>
            <p class="px-3 mb-3">
            <ul>
                <li>Users must create an account to access certain features of the System, such as submitting and tracking
                    donations.</li>
                <li>You are responsible for safeguarding your account credentials and for all actions taken under your
                    account.</li>
                <li>If you suspect unauthorized access to your account, contact the System Admin immediately.</li>
            </ul>
            </p>

            <h3 class="mb-2">5. Donation Submission</h3>
            <p class="px-3 mb-3">
            <ul>
                <li>
                    Donors are required to provide accurate and complete information regarding the items they wish to
                    donate, including descriptions, quantities, and expiration dates (where applicable).
                </li>
                <li>
                    Donations are subject to review and approval by Barangay Admins. You will be notified of the approval
                    status via the System.
                </li>
            </ul>
            </p>

            <h3 class="mb-2">6. Prohibited Activities</h3>
            <p class="px-3 mb-3">
                You agree not to:
            <ul>
                <li>Submit donations that are expired, damaged, or do not comply with the System’s guidelines.
                </li>
                <li>Engage in fraudulent activities or impersonate others.
                </li>
                <li>Attempt to hack, disrupt, or compromise the security of the System.</li>
            </ul>
            </p>

            <h3 class="mb-2">7. Transparency and Notifications</h3>
            <p class="px-3 mb-3">
            <ul>
                <li>The System provides real-time updates on donation statuses through the Transparency Board.
                </li>
                <li>Barangay Admins are responsible for posting updates on donation distribution and the status of available
                    resources.
                </li>
                <li>Automated notifications will be sent regarding donation approvals, urgent needs, and system updates.
                </li>
            </ul>
            </p>

            <h3 class="mb-2">8. Inventory Management</h3>
            <p class="px-3 mb-3">
                Barangay Admins are responsible for accurately maintaining the inventory of donated items. This includes
                updating stock levels, posting notifications about donation needs, and informing users when donations are no
                longer required.
            </p>

            <h3 class="mb-2">9. Data Privacy</h3>
            <p class="px-3 mb-3">
            <ul>
                <li>The System collects personal information, including names, contact details, and donation history, which
                    is used solely to manage donations and provide relevant updates.
                </li>
                <li>The System employs industry-standard data protection measures to safeguard user information.</li>
                <li>Your data will not be shared with third parties except as required by law or as part of the donation
                    process.</li>
            </ul>
            </p>

            <h3 class="mb-2">10. Limitation of Liability</h3>
            <p class="px-3 mb-3">
                The System and its administrators are not responsible for:
            <ul>
                <li>Inaccuracies or incomplete information provided by Donors.</li>
                <li>The misuse or mismanagement of donated items once they are distributed by the barangays.</li>
                <li>Delays or errors in processing donations due to system malfunctions or human error.</li>
            </ul>
            </p>

            <h3 class="mb-2">11. Termination of Use</h3>
            <p class="px-3 mb-3">
                The System reserves the right to terminate or suspend User accounts at any time if it is found that the User
                has violated these Terms and Conditions or engaged in prohibited activities.
            </p>

            <h3 class="mb-2">12. Amendments</h3>
            <p class="px-3 mb-3">
                The System reserves the right to amend these Terms and Conditions at any time. Users will be notified of
                significant changes through the System. Continued use of the System after changes have been posted
                constitutes acceptance of the revised terms.
            </p>

            <h3 class="mb-2">13. Governing Law</h3>
            <p class="px-3 mb-3">
                These Terms and Conditions are governed by the laws of the Philippines. Any disputes arising out of or
                related to the use of the System will be subject to the jurisdiction of the courts in Parañaque City.
            </p> --}}
            {!! $page->content !!}
        </div>

    </div>

@endsection
