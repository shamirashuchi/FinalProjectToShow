$(document).ready(function () {
    $(".noUi-handle").on("click", function () {
        $(this).width(50);
    });

    let rangeSlider = $("#slider-range");
    let maxSalaryRange = parseInt(rangeSlider.data('maxSalaryRange'))
    if (rangeSlider.length > 0) {
        let moneyFormat = wNumb({
            decimals: 0,
            thousand: ",",
            prefix: ""
        });

        noUiSlider.create(rangeSlider[0], {
            start: rangeSlider.data('currentRange'),
            animate: false,
            tooltips: true,
            step: 1,
            range: {
                min: 0,
                max: maxSalaryRange
            },
            format: moneyFormat
        });

        // Set visual min and max values and also update value hidden form inputs
        rangeSlider[0].noUiSlider.on("update", function (values, handle) {
            $(".min-value-money").val(values[0]);
            $(".max-value-money").val(values[1]);
            $(".min-value").val(moneyFormat.from(values[0]));
            $(".max-value").val(moneyFormat.from(values[1]));
        });
    }
});
