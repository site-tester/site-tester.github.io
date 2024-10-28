<style>
    @media print {

        /* Hide the sidebar and other non-essential elements */
        .navbar,
        .sidebar,
        .btn,
        .overview {
            display: none;
        }

        /* Adjust margins, font sizes, etc., for print */
        body {
            margin: 0;
            font-size: 12px;
        }
    }
</style>

<button class="btn btn-secondary" onclick="printPage()">
    <i class="la la-print"></i> Print
</button>

<script>
    function printPage() {
        // Open the print dialog
        window.print();
    }
</script>
