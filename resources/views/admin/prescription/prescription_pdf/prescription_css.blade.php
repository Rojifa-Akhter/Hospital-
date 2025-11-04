<style>
    @page{
            margin-top: 2.8cm;
            margin-bottom: 2cm !important;
            margin-left: 1cm;
            margin-right: 0.8cm;
        }
    body {
            margin-left: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 1.5cm;
            font-size: 13px;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            color: #000000;
        }
        header {
            position: fixed;
            top: 1cm;
            height: 2.5cm;
            /* border-bottom: 1px solid; */
            width: 100%
                /* color: #007FD2; */
        }

    table{
            border-collapse: collapse;
            width: 100%;
        }

    td,th{
            padding: 2px !important;
        }

    .text-center{
        text-align: center;
    }
    .text-left{
            text-align: left;
        }
    .text-right{
        text-align: right;
    }
    .border-0{
        border: 0px;
    }
    .pt-5{
        padding-top: 20px
    }
    .no-break {
        page-break-inside: avoid;
    }   
    .py-3{
        padding: 12px 0px; 
    }
    .py-2{
        padding: 8px 0px; 
    }
    .ml-20{
        margin-left: 20px;
    }
    .pl-15{
        padding-left: 15 px;
    }
    .mb-5 {
            margin-bottom: 15px;
    }
    ul {
        padding: 0;
        margin: 0;
        padding-top: 5px;
    }
    ul li {
        margin-bottom: 5px;
        font-size: 11px;
    }
    @font-face {
            font-family: 'IBM Plex Sans';
            src: url("{{ storage_path('fonts/IBMPlexSans-Regular.ttf') }}") format('truetype');
    }

     @font-face {
            font-family: 'Kalpurush';
            src: url("{{ storage_path('fonts/kalpurush.ttf') }}") format('truetype');
    }
    .teeth-table{
        border-collapse: unset !important
    }
    .teeth-table td {
            border: 1px solid #000;
        }
    .border-right {
            border-right: 1px solid #000000;
    }
    .border-less {
            border: 1px solid #fff !important;
        }

    .bg-danger{
        background-color: red
    }
    .doctor_sigature p {
        margin: 0;
    }

    .print_by{
        /* position: fixed; */
        z-index: 999999999;
        bottom: 0px;
        left: 0px;
        right: 0px;
        vertical-align: text-bottom;
        padding-top: 10px;
    }

</style>