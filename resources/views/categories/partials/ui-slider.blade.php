<div id="{{ $field }}-step" data-step-{{ $field }}="{{ $step }}" class="row g-2 mb-2">
    <div class="col-6">
        <div class="input-group input-group-sm">
            <span class="input-group-text bg-white border-end-0">от</span>
            <input
                data-min-{{ $field }}={{ $min }}
                type="number"
                class="form-control form-control-sm border-start-0"
                id="{{ $field }}-min"
                name="{{ $field }}-min"
                value="{{ $currentMin ?? $min }}"
                min="{{ $min }}"
                max="{{ $max }}">
        </div>
    </div>
    <div class="col-6">
        <div class="input-group input-group-sm">
            <span class="input-group-text bg-white border-end-0">до</span>
            <input
                data-max-{{ $field }}={{ $max }}
                type="number"
                class="form-control form-control-sm border-start-0"
                id="{{ $field }}-max"
                name="{{ $field }}-max"
                value="{{ $currentMax ?? $max }}"
                min="{{ $min }}"
                max="{{ $max }}">
        </div>
    </div>
</div>
<div id="{{ $field }}-slider" class="ui-slider"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sliderId = '{{ $field }}-slider';
        const minId = '{{ $field }}-min';
        const maxId = '{{ $field }}-max';
        const stepId = '{{ $field }}-step';

        const slider = document.getElementById(sliderId);
        const fieldMin = document.getElementById(minId);
        const fieldMax = document.getElementById(maxId);
        const fieldStep = document.getElementById(stepId);

        const dataAttrMin = 'data-min-{{ $field }}';
        const dataAttrMax = 'data-max-{{ $field }}';
        const dataAttrStep = 'data-step-{{ $field }}';

        const minPossible = parseFloat(fieldMin.getAttribute(dataAttrMin));
        const maxPossible = parseFloat(fieldMax.getAttribute(dataAttrMax));
        const step = parseFloat(fieldStep.getAttribute(dataAttrStep));

        const currentMin = parseFloat(fieldMin.value);
        const currentMax = parseFloat(fieldMax.value);

        noUiSlider.create(slider, {
            start: [currentMin, currentMax],
            connect: true,
            range: {
                'min': minPossible,
                'max': maxPossible
            },
            step: step,
            format: {
                to: value => Math.round(value),
                from: value => Math.round(value)
            }
        });

        slider.noUiSlider.on('update', function(values, handle) {
            if (handle === 0) {
                fieldMin.value = values[0];
            } else {
                fieldMax.value = values[1];
            }
        });

        fieldMin.addEventListener('change', function() {
            let val = parseFloat(this.value);
            if (val < minPossible) val = minPossible;
            if (val > parseFloat(fieldMax.value)) val = parseFloat(fieldMax.value);
            this.value = val;
            slider.noUiSlider.set([val, null]);
        });

        fieldMax.addEventListener('change', function() {
            let val = parseFloat(this.value);
            if (val > maxPossible) val = maxPossible;
            if (val < parseFloat(fieldMin.value)) val = parseFloat(fieldMin.value);
            this.value = val;
            slider.noUiSlider.set([null, val]);
        });
    });
</script>