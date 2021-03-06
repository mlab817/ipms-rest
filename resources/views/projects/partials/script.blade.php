@push('scripts')
    <script>
        // -- Select/Unselect Regions
        let selectRegions = $('#selectRegions');
        let clearRegions = $('#clearRegions');

        selectRegions.click(function () {
            //
            $('.regions-checkboxes').prop('checked', true)
            $('.regions-checkboxes:checkbox[value="100"]').prop('checked', false)
        })

        clearRegions.click(function () {
            $('.regions-checkboxes').prop('checked', false)
            $('.regions-checkboxes:checkbox[value="100"]').prop('checked', true)
        })
    </script>

    <script>
        /**
         * pdp_chapter_id onChange
         * no_pdp_indicators onChange
         *
         * Hide/Show indicators group by chapter
         * Uncheck indicators
        */
        let pdpChapters = @json($pdp_chapters->pluck('id')->toArray());

        let pdpChapterId = $('#pdp_chapter_id');

        function toggleVisibleIndicators()
        {
            let selectedPdpChapterId = pdpChapterId.val();
            $.each(pdpChapters, function (chapter) {
                if (parseInt(chapter) !== parseInt(selectedPdpChapterId)) {
                    $('div#pdp_chapter_' + chapter).hide();
                }
            });
            $('div#pdp_chapter_' + selectedPdpChapterId).show();
        }

        pdpChapterId.change(function () {
            // uncheck all checked if the pdp chapter changed
            $('input.pdp_indicators').prop('checked', false)
            toggleVisibleIndicators();
        });

        let noPdpIndicator = $('#no_pdp_indicator');

        function toggleDisableIndicators() {
            console.log(noPdpIndicator.val())
            if (noPdpIndicator.is(':checked')) {
                $('input.pdp_indicators').prop('disabled', true)
            } else {
                $('input.pdp_indicators').prop('disabled', false)
            }
        }

        noPdpIndicator.change(function () {
            toggleDisableIndicators()
        });

        $(document).ready(function () {
            console.log('document is ready')
            // on document ready toggle visible indicators
            toggleVisibleIndicators();
            toggleDisableIndicators()
        });
    </script>

    <script>
        function formatToMoney(value) {
            console.log('formatToMoney initial value: ', value)
            if (parseFloat(value) === 0) return 0
            return value
                .toString()
                .replace(/\.00$/,'')
                .replace(/^0+/,'')
                .replace(/\D/g, '')
                .replace(/\B(?=(\d{3})+(?!\d))/g, ',')
        }

        $('input.money').keyup(function (evt) {
            if (event.which >= 37 && event.which <= 40) return

            $(this).val(function (index, value) {
                if (parseInt(value) === 0) return 0
                return formatToMoney(value)
            })
        })

        const listenersForSum = [
            'nep',
            'fs',
            'allocation',
            'disbursement',
            'fs_investments',
            'fs_investments_2016',
            'fs_investments_2017',
            'fs_investments_2018',
            'fs_investments_2019',
            'fs_investments_2020',
            'fs_investments_2021',
            'fs_investments_2022',
            'fs_investments_2023',
            'fs_investments_1',
            'fs_investments_2',
            'fs_investments_3',
            'fs_investments_4',
            'fs_investments_5',
            'fs_investments_6',
            'fs_investments_7',
            'fs_investments_8',
            'fs_investments_9',
            'region_investments_2016',
            'region_investments_2017',
            'region_investments_2018',
            'region_investments_2019',
            'region_investments_2020',
            'region_investments_2021',
            'region_investments_2022',
            'region_investments_2023',
            'region_investments',
        ]

        const regions = @json($regions->pluck('id')->toArray()).map(region => ('region_investments_' + region))

        listenersForSum.push(...regions)

        console.log(listenersForSum)

        const $doc = $(document)

        function calculateSum(items) {
            console.log('calculating sum of ', items)
            // initialize sum variable
            let sum = 0
            // iterate over items
            $('.' + items).each(function() {
                // format the value first
                let $this = $(this)
                let val = parseFloat($this.val() ? $this.val().replace(/,/g, '') : 0)
                sum += val
            })

            $('#' + items + '_total').val(formatToMoney(sum))
        }

        $doc.ready(function () {
            // initializeSelect2()

            $('.money').each(function() {
                $(this).val(formatToMoney($(this).val()))
            })

            listenersForSum.forEach(listener => {
                console.log('calculating for ', listener)
                calculateSum(listener)
            })
        })

        listenersForSum.forEach(listener => {
            $('.' + listener).on('keyup blur', function() {
                calculateSum(listener)
            })
        })
    </script>
@endpush
