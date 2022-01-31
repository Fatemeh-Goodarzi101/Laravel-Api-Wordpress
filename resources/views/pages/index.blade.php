@extends('pages.panel')

@section('content')

    <div class="card mt-5" style="width: 50%; margin: auto;box-shadow: 1px 1px 1px #00000020;">
        <div class="card-body">
            <pre style="white-space: pre-line; direction: rtl; font-family: 'Samim'; font-size: 14px !important; word-break: unset !important;">
            مواردی که باید دقت کنید:
            1- هر فایل رو توی فرم درست آپلود کنید چون فرم ها با هم فرق میکنن و اگر اشتباه این کار رو انجام بدید اطلاعات غلط وارد دیتابیس میشه.
            2- به محض آپلود فایل ها اطلاعات وارد شده جایگزین میشوند پس اگر فایل اشتباهی با قیمت ها یا ستون های اشتباهی وارد کنید، راه جبرانی به جز دستی انجام دادن کار وجود نداره.
            3- حتما حتمااا و حتمااااا از نمونه فایل های قرار داده شده در پیوست همین پیام استفاده کنید چون به جز این اطلاعات به درستی وارد نمیشوند.
            4- قیمت های وارد شده برای هر قسمت باید به تومان باشد پس اگر قیمت های بازرگانی به ریال است آن را به تومان تبدیل کنید.
            5- اگر بارکد محصولی که وارد میکنید اشتباه باشه پیغامی با متن "بارکد محصول معتبر نمی باشد" بعلاوه بارکد موردنظر نمایش داده میشه و ردیف های بعد از اون محصول در اکسل اعمال نمیشه، پس باید بارکد رو درست کنید و دوباره فایل رو آپلود کنید.
            6- اگر پیغام "بارکد محصول معتبر نمی باشد" رو بدون عدد بارکد به عنوان خروجی کار دیدید، اول پیشخوان رو چک کنید چون احتمالا تغییرات اعمال شده و این پیام مربوط به سطرهای خالی موجود در اکسل هست
            </pre>
            <pre style="white-space: pre-line; direction: rtl; font-family: 'Samim'; font-size: 14px !important; word-break: unset !important;">
                نمونه فایل های قابل دانلود:
                <hr>
                <a style="color: #434343;display: block;" href="/sampleFiles/نمونه فایل تغییر نام محصولات.xlsx" download> <span>نمونه فایل تغییر نام محصولات</span></a>
                <a style="color: #434343;display: block;" href="/sampleFiles/نمونه فایل تغییر موجودی محصولات.xlsx" download><span>نمونه فایل تغییر موجودی محصولات</span></a>
                <a style="color: #434343;display: block;" href="/sampleFiles/نمونه فایل تغییر قیمت محصولات.xlsx" download><span>نمونه فایل تغییر قیمت محصولات</span></a>
                <a style="color: #434343;display: block;" href="/sampleFiles/نمونه فایل تغییر قیمت عادی محصولات.xlsx" download><span>نمونه فایل تغییر قیمت عادی محصولات</span></a>
                <a style="color: #434343;display: block;" href="/sampleFiles/نمونه فایل تغییر قیمت فروش ویژه محصولات.xlsx" download><span>نمونه فایل تغییر قیمت فروش ویژه محصولات</span></a>
            </pre>
        </div>
    </div>

@endsection
