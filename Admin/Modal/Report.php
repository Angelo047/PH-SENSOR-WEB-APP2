<style>
    body.modal-open .modal {
        display: block;
        overflow-y: auto;
    }

    @media print {
        .modal {
            position: absolute;
            left: 0;
            top: 0;
            margin: 0;
            padding: 0;
            border: none;
            width: 100%;
        }

        .modal-content {
            box-shadow: none;
        }

        .modal-header,
        .modal-footer {
            display: none;
        }
    }

    /* Additional styling for better readability */
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
    }

    h1, h2, h3, h4, h5, h6 {
        font-weight: bold;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    img {
        max-width: 100%;
        height: auto;
    }

    .custom-modal-padding {
        padding: 50px; /* Adjust the padding value as needed */
    }
</style>

<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content custom-modal-padding">
            <div class="modal-body" id="reportModalBody">
                <!-- Report content will be dynamically generated here -->
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-primary" onclick="printReport()">Print</button> -->
                <button type="button" class="btn btn" onclick="saveAsPDF()" style="background-color:#3f51b5; color:white;"><i class="fa-solid fa-file-arrow-down"></i> GENERATE</button>
            </div>
        </div>
    </div>
</div>
