<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Typeahead JS Autocomplete Search</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js">    
    </script> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <style>
        .container {                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
            max-width: 600px;
        }
    </style>
    </head>
    <body>
    <div class="container mt-5">
        <div classs="form-group">
            <input type="text" id="customer" name="search" placeholder="Search" class="form-control" value="" />
        </div>
        <div classs="form-group">
            <input type="hidden" id="abc" name="search_value" placeholder="Search" class="form-control" value="" />
        </div>
    </div>
    
    <script type="text/javascript">
        $(document).ready(function() {
        var cname = @json($cust);
        $('#customer').autocomplete({
            source: cname, // URL to fetch suggestions
            minLength: 2, // Minimum characters required before autocomplete starts
            select: function(event, ui) {
                // Handle the selected item (ui.item.value)
                console.log(ui,"ftext");
                $('#abc').val(ui.item.values);                

            }
        });
    });
    </script>
</body>

    
</html>