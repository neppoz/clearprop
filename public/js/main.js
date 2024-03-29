$(document).ready(function () {
  window._token = $('meta[name="csrf-token"]').attr('content')

  moment.updateLocale('{{ app()->getLocale() }}', {
    week: {dow: 1} // Monday is the first day of the week
  })

  $('.date').datetimepicker({
      format: 'DD/MM/YYYY',
      locale: '{{ app()->getLocale() }}',
      icons: {
          up: 'fas fa-chevron-up',
          down: 'fas fa-chevron-down',
          previous: 'fas fa-chevron-left',
          next: 'fas fa-chevron-right'
      }
  })

  $('.datetime').datetimepicker({
      format: 'DD/MM/YYYY HH:mm',
      locale: '{{ app()->getLocale() }}',
      sideBySide: true,
      toolbarPlacement: 'bottom',
      showTodayButton: false,
      showClear: true,
      showClose: true,
      viewMode: 'days',
      inline: false,
      widgetPositioning: {
          horizontal: 'auto',
          vertical: 'bottom'
      },
      icons: {
          time: 'fas fa-clock-o',
          date: 'fas fa-calendar-alt',
          up: 'fas fa-chevron-up',
          down: 'fas fa-chevron-down',
          previous: 'fas fa-chevron-left',
          next: 'fas fa-chevron-right',
          today: 'fas fa-dot-circle',
          clear: 'fas fa-trash-alt',
          close: 'fas fa-check-circle',

      },
  })

  $('.timepicker').datetimepicker({
    format: 'HH:mm',
    icons: {
      up: 'fas fa-chevron-up',
      down: 'fas fa-chevron-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right'
    }
  })

  $('.select-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', 'selected')
    $select2.trigger('change')
  })
  $('.deselect-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', '')
    $select2.trigger('change')
  })

  $('.select2').select2()

  $('.treeview').each(function () {
    var shouldExpand = false
    $(this).find('li').each(function () {
      if ($(this).hasClass('active')) {
        shouldExpand = true
      }
    })
    if (shouldExpand) {
      $(this).addClass('active')
    }
  })

})
