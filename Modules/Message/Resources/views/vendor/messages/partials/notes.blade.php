<div class="portlet light bordered">
    <div class="portlet-title">
        <div class="caption font-red-sunglo">
            <i class="icon-settings font-red-sunglo"></i>
            <span class="caption-subject bold uppercase">
                {{__('message::dashboard.messages.notes')}}
            </span>
        </div>
    </div>
    <div class="portlet-body form">
        <div class="form-body" style="padding:0">
            @inject('pages','Modules\Page\Entities\Page')
            {!! $pages->find(2)?->description !!}
{{--            <ul class="notes" style="list-style: decimal">--}}
{{--                <li>لابد ان يكون الرقم فعال في التواصل مع الغير وليس رقم جديث التفعيل.</li>--}}
{{--                <li>تجنب الارسال العشوائي.</li>--}}
{{--                <li>ان يكون الارسال مع ارقام تم التواصل معها سابقا وان يكون المستقبل مهتما بما ترسل او علي الاقل ان طبيعة الرسلة غير مزعجة.</li>--}}
{{--                <li>التدرج في كمية الارسال اليومي البداية بكميات قليلة ثم رفع كمية الارسال يوميا.</li>--}}
{{--                <li>عدم ارسال اكثر من 5000 رسالة يوميا.</li>--}}
{{--                <li>في المنصة نستخدم عدة اليات في الفاصل الزمني وننصح باستخدام الفاصل الزمني الاختياري من صفحة الارسال.</li>--}}
{{--                <li>ننصح بايقاف عملية الارسال القائمة يدويا بين فترة واخري عبر زر ايقاف الارسال الموجود في سجل الارسال.</li>--}}
{{--                <li>عدم ارفاق الكثير من الروابط في المحتوي.</li>--}}
{{--                <li>الرد سريعا علي الرسائل الواردة والتواصل مع الاخرين يعتبر ميزة لصالح الرقم.</li>--}}
{{--                <li>نذكر ان المزيد من البلاغات عن رقم الارسال سيزيد من فرص حجب الرقم.</li>--}}
{{--            </ul>--}}
        </div>
    </div>
</div>
