<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
  <tr>
    <th class="px-6 py-3 asian">{{ __('td1') }}</th>
    <th class="px-6 py-3 asian">{{ __('td2') }}</th>
  </tr>
  <tr>
    <td class="px-6 py-3 asian">{{ __('td3') }}</td>
    <td class="px-6 py-3 asian">{{ __('td4') }}</td>
  </tr>
  <tr>
    <td class="px-6 py-3 asian">{{ __('td5') }}</td>
    <td class="px-6 py-3 asian">{{ __('td6') }}</td>
  </tr>
</table>

<style>
  table {
    table-layout: fixed; 
    width: 100%;
  }
  .asian {
    font-family: "simsun";
    word-wrap: break-word;
    word-break: break-all;
  }
</style>