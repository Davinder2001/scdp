<footer class="main-footer">
    <strong>Copyright &copy; 2022-<span id="year"></span> <a href="#">SCDP</a>.</strong>
    All rights reserved.
</footer>
<script>
    document.getElementById("year").innerHTML = new Date().getFullYear();
</script>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Function to convert number to different units
    function convertNumber(value, unit) {
        switch(unit) {
            case 'thousand':
                return (value / 1000).toFixed(2) + ' K';
            case 'lakh':
                return (value / 100000).toFixed(2) + ' Lakh';
            case 'crore':
                return (value / 10000000).toFixed(2) + ' Cr';
            default:
                return value.toLocaleString();
        }
    }

    // Function to apply conversion to all relevant table cells within tbody
    function applyConversion(unit) {
        $('#tbody').find('.change_numaric').each(function() {
            var originalValue = $(this).data('original-value');
            if (!originalValue) {
                originalValue = $(this).text().replace(/,/g, '');
                $(this).data('original-value', originalValue);
            }
            if ($.isNumeric(originalValue)) {
                $(this).text(convertNumber(parseFloat(originalValue), unit));
            }
        });
    }

    $(document).ready(function() {
        // Retrieve selected option from localStorage
        var selectedUnit = localStorage.getItem('selectedUnit');
        if (selectedUnit) {
            $('#numeric_values').val(selectedUnit); // Set dropdown to saved value
            applyConversion(selectedUnit); // Apply conversion based on saved value
        }

        // Event listener for the "Display Unit" dropdown
        $(document).on("change", "#numeric_values", function() {            
            var selectedUnit = $(this).val();
            applyConversion(selectedUnit);
            localStorage.setItem('selectedUnit', selectedUnit); // Save selected option to localStorage
        });
    });
</script>

