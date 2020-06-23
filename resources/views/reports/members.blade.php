<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ trans('panel.site_title') }}</title>
</head>
<body>
    <style type="text/css">
        .tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc;}
        .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-top-width:1px;border-bottom-width:1px;border-color:#ccc;color:#333;background-color:#fff;}
        .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:0px;overflow:hidden;word-break:normal;border-top-width:1px;border-bottom-width:1px;border-color:#ccc;color:#333;background-color:#f0f0f0;}
        .tg .tg-8ob6{font-family:Arial, Helvetica, sans-serif !important;border-color:inherit;text-align:right;vertical-align:middle}
        .tg .tg-l1af{font-family:Arial, Helvetica, sans-serif !important;border-color:inherit;text-align:left;vertical-align:middle}
        .tg .tg-cly1{text-align:left;vertical-align:middle}
        .tg .tg-baqh{text-align:center;vertical-align:top}
        .tg .tg-lqy6{text-align:right;vertical-align:top}
        .tg .tg-0lax{text-align:left;vertical-align:top}
        .tg .tg-dzk6{background-color:#f9f9f9;text-align:center;vertical-align:top}
        .tg .tg-p5oz{background-color:#f9f9f9;text-align:right;vertical-align:top}
        .tg .tg-p5o1{background-color:#f9f9f9;text-align:left;vertical-align:top}
        .tg .tg-0uou{font-weight:bold;color:#9a0000;text-align:center;vertical-align:top}
        .tg .tg-wa1i{font-weight:bold;text-align:center;vertical-align:middle}
        .tg .tg-nrix{text-align:center;vertical-align:middle}
        .tg .tg-vkwr{font-weight:bold;color:#009901;text-align:center;vertical-align:top}
        .tg .tg-amwm{font-weight:bold;text-align:center;vertical-align:top}
    </style>
    <!-- -->
    <table class="tg" width="100%" style="width:100%">
        <tr>
            <td class="tg-l1af"></td>
            <td class="tg-8ob6">{{ $userid->name }}</td>
        </tr>
    </table>
    <br>
    <h3>{{__('Financial summary')}}</h3>
    <table class="tg" width="100%" style="width:100%">
        <tr>
            <th class="tg-nrix">{{__('Total billings')}}</th>
            <th class="tg-nrix">{{__('Total activities')}}</th>
            <th class="tg-nrix">{{__('Total hours')}}</th>
            <th class="tg-wa1i">{{__('Balance')}}</th>
        </tr>
        <tr>
            @if($incomeAmountTotal >=0 )
                <td class="tg-vkwr">{{ number_format($incomeAmountTotal, 2, ',', '.') }} &euro;</td>
            @else
                <td class="tg-0uou">{{ number_format($incomeAmountTotal, 2, ',', '.') }} &euro;</td>
            @endif
            <td class="tg-0uou">{{ number_format($activityAmountTotal, 2, ',', '.') }} &euro;</td>
            <td class="tg-amwm">{{ $activityHoursAndMinutes }}</td>
            @if($granTotal >= 0)
                <td class="tg-vkwr">{{ number_format($granTotal, 2, ',', '.') }} &euro;</td> <!-- positive value -->
            @else
                <td class="tg-0uou">{{ number_format($granTotal, 2, ',', '.') }} &euro;</td> <!-- negative value -->
            @endif
        </tr>
    </table>
    <br>
    <h5>{{__('Activities summary')}}</h5>
    <table class="tg" width="100%" style="width:100%">
        <tr>
            <th class="tg-cly1">{{__('Date')}}</th>
            <th class="tg-cly1">{{__('Event start')}}</th>
            <th class="tg-0lax">{{__('Event stop')}}</th>
            <th class="tg-baqh">{{__('Minutes')}}</th>
            <th class="tg-lqy6">{{__('€/min')}}</th>
            <th class="tg-lqy6">{{__('Amount')}}</th>
        </tr>
        @foreach($activity_lines as $activityline)
        <tr>
            <td class="tg-0lax">{{ $activityline->event }}</td>
            <td class="tg-dzk6">{{ $activityline->counter_start }}</td>
            <td class="tg-baqh">{{ $activityline->counter_stop }}</td>
            <td class="tg-dzk6">{{ $activityline->minutes }}</td>
            <td class="tg-lqy6">{{ $activityline->rate }} &euro;</td>
            <td class="tg-p5oz">{{ $activityline->amount }} &euro;</td>
        </tr>
        @endforeach
    </table>
    <br>
    <h5>{{__('Billing summary')}}</h5>
    <table class="tg" width="100%" style="width:100%">
        <tr>
            <th class="tg-cly1">{{__('Date')}}</th>
            <th class="tg-cly1">{{__('Reason')}}</th>
            <th class="tg-lqy6">{{__('Amount')}}</th>
        </tr>
        @foreach($income_lines as $billingline)
        <tr>
            <td class="tg-0lax">{{ $billingline->entry_date }}</td>
            <td class="tg-p5o1">{{ $billingline->income_category->name }}</td>
            <td class="tg-lqy6">{{ $billingline->amount }}  &euro;</td>
        </tr>
        @endforeach
    </table>
</body>
</html>


