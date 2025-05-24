<div class="form-group row  mb-2">
    <label class="col-xs-4">{{__('message::dashboard.messages.bulk_contacts')}} </label>
    <div class="col-xs-8">
        <div class="mt-radio-inline">
            <label class="mt-radio mt-radio-outline">
                {{ __('message::dashboard.messages.group_numbers') }}
                <input type="radio" name="bulk_flag" value="numbers_groups"
                       onclick="toggleBulkFlag('numbers_groups')" checked>
                <span></span>
            </label>
            <label class="mt-radio mt-radio-outline">
                {{ __('message::dashboard.messages.new_contacts') }}
                <input type="radio" name="bulk_flag" value="new_contacts"
                       onclick="toggleBulkFlag('new_contacts')">
                <span></span>
            </label>
            <label class="mt-radio mt-radio-outline">
                {{ __('message::dashboard.messages.contacts') }}
                <input type="radio" name="bulk_flag" value="contacts"
                       onclick="toggleBulkFlag('contacts')">
                <span></span>
            </label>
            <label class="mt-radio mt-radio-outline">
                {{ __('message::dashboard.messages.excel_contacts') }}
                <input type="radio" name="bulk_flag" value="excel_contacts"
                       onclick="toggleBulkFlag('excel_contacts')">
                <span></span>
            </label>
        </div>
    </div>
</div>
