<?php
    define('API_KEY','1972547766:AAE1u0TyiRnsIo7X1rzMXSQkIBlhq8_99BQ');

    $admin = "-15122000"; // admin idsi
    $adminuser = "mislombek"; // admin user

    function del($nomi){
        array_map('unlink', glob("step/$nomi.*"));
    }
    function put($fayl, $nima){
        file_put_contents("$fayl", "$nima");
    }

    function pstep($cid,$zn){
        file_put_contents("step/$cid.step",$zn);
    }

    function step($cid){
        $step = file_get_contents("step/$cid.step");
        $step += 1;
        file_put_contents("step/$cid.step",$step);
    }

    function nextTx($cid,$txt){
        $step = file_get_contents("step/$cid.txt");
        file_put_contents("step/$cid.txt","$step\n$txt");
    }

    function ty($ch){
        return bot('sendChatAction', [
            'chat_id' => $ch,
            'action' => 'typing',
        ]);
    }

    function ACL($callbackQueryId, $text = null, $showAlert = false)
    {
        return bot('answerCallbackQuery', [
            'callback_query_id' => $callbackQueryId,
            'text' => $text,
            'show_alert' => $showAlert,
        ]);
    }

    function bot($method,$datas=[]){
        $url = "https://api.telegram.org/bot".API_KEY."/".$method;
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
        $res = curl_exec($ch);
        if(curl_error($ch)){
            var_dump(curl_error($ch));
        }else{
            return json_decode($res);
        }
    }

    $update = json_decode(file_get_contents('php://input'));
    $message = $update->message;
    $cid = $message->chat->id;
    $cidtyp = $message->chat->type;
    $miid = $message->message_id;
    $name = $message->chat->first_name;
    $user = $message->from->username;
    $tx = $message->text;
    $callback = $update->callback_query;
    $mmid = $callback->inline_message_id;
    $mes = $callback->message;
    $mid = $mes->message_id;
    $cmtx = $mes->text;
    $mmid = $callback->inline_message_id;
    $idd = $callback->message->chat->id;
    $cbid = $callback->from->id;
    $cbuser = $callback->from->username;
    $data = $callback->data;
    $ida = $callback->id;
    $cqid = $update->callback_query->id;
    $cbins = $callback->chat_instance;
    $cbchtyp = $callback->message->chat->type;
    $step = file_get_contents("step/$cid.step");
    $menu = file_get_contents("step/$cid.menu");
    $stepe = file_get_contents("step/$cbid.step");
    $menue = file_get_contents("step/$cbid.menu");
    // mkdir("step");

    $otex = "😔 Bekor qilish";

    $keys = json_encode([
        'resize_keyboard'=>true,
        'keyboard' => [
            [['text' => "🎓 Kurslar"],],
            [['text' => "ℹ️ Biz haqimizda"],['text' => "📞 Aloqa"],],
            [['text' => "📍 Manzil"],['text' => "📝 Ro'yxatdan o'tish"],],
        ]
    ]);



    $otmen = json_encode([
        'resize_keyboard'=>true,
        'keyboard'=>[
            [['text'=>"$otex"],],
        ]
    ]);

    $phone = json_encode([
        'resize_keyboard'=>true,
        'keyboard'=>[
            [["text"=>"📲 Telefon raqamni yuborish","request_contact"=>true],],
        ]
    ]);

    $manzil = json_encode(
        ['inline_keyboard' => [
        [['callback_data' => "😊 Ajoyib", 'text' => "😊 Ajoyib"],['callback_data' => "😕 Yaxshi", 'text' => "😕 Yaxshi"],],
        ],'resize_keyboard'=>false,
    ]);

    $kurs = json_encode([
        'resize_keyboard' => true,
        'keyboard' => [
            [['text' => "📋Kompyuter savodxonligi"],['text' => "📚 IT-English"],],
            [['text' => "🖥 Frontend dasturlash"], ['text' => "💻 Backend dasturlash"],],
            [['text' => "🏙 Grafik dizayn"], ['text' => "🤖 Mobil robototexnika"],],
            [['text' => "🔙 Ortga qaytish"],],
        ]
    ]);

    $kurslar = json_encode([
        'resize_keyboard' => true,
        'keyboard' => [
            [['text' => "Kompyuter savodxonligi"],['text' => "IT-English"],],
            [['text' => "Frontend dasturlash"], ['text' => "Backend dasturlash"],],
            [['text' => "Grafik dizayn"], ['text' => "Mobil robototexnika"],],
        ]
    ]);

    $tumanlar = json_encode([
        'resize_keyboard' => true,
        'keyboard' => [
            [['text' => "Guliston shahri"]],
            [['text' => "Mirzaobod"], ['text' => "Sirdaryo"],],
            [['text' => "Sayxunobod"], ['text' => "Guliston"],],
            [['text' => "Boyovut"], ['text' => "Oqoltin"],],
            [['text' => "Sardoba"], ['text' => "Xovos"],],
        ]
    ]);

    $tasdiq = json_encode(
        ['inline_keyboard' => [
            [['callback_data' => "ok", 'text' => "Ha 👍"],['callback_data' => "clear", 'text' => "Yo'q 👎"],],
        ]
    ]);

    if(isset($tx)){
        ty($cid);
    }



    if($tx == "/start"){
        bot('sendMessage', [
            'chat_id' => $cid,
            'text' => "*Assalomu alaykum, $name!* Sizga qanday yordam bera olishimiz mumkin?",
            'parse_mode' => 'markdown',
            'reply_markup' => $keys,
        ]);
    }
    if ($tx == "ℹ️ Biz haqimizda") {
        bot('sendPhoto', [
            'chat_id' => $cid,
            'photo'=> 'https://static10.tgstat.ru/channels/_0/58/5896a0e68fb821bd591bdf89e48900a3.jpg',
            'caption' => "*IT Center Uzbekistan*\n*Sening IT karyerang shu yerdan boshlanadi!*\n\n*IT koʻnikmalarini egallashni, malakangizni oshirishni, moʻmay daromad qilishni yoki IT sohasida ingliz tilini oʻrganishni istaysizmi? Biz sizga yordam beramiz! Bizning yuqori malakali murabbiylarimiz axborot texnologiyalarining barcha yoʻnalishlari haqida sizga zarur bilimlarni berishadi, koʻrsatishadi va hikoya qilishadi. Biz sizga zamonaviy kitob va qoʻllanmalar asosida IT bilimlarni taqdim etamiz. Kurslarimizdan roʻyxatdan oʻting!*",
            'parse_mode' => 'markdown',
            'reply_markup' => $keys,
        ]);
    }

    if ($tx == "📞 Aloqa") {
        bot('sendPhoto', [
            'chat_id' => $cid,
            'photo' => 'https://it-park.uz/storage/images/newsimage/IMG_4841_1593527957.JPG',
            'caption' => "*Biz bilan bog'lanish: *\n\n*📞 Tel.: +998(99)0351199\n📧 Telegram: @itcentersirdaryosupport\n*🌐 Sayt: [www.itcenter.uz]\n\n*Ijtimoiy tarmoqlar:*\nTelegram kanal: [@itparkgulistan]\nTelegram guruh: [@it_park_gulistan]",
            'parse_mode' => 'markdown',
            'reply_markup' => $keys,
        ]);
    }
    if ($tx == "📍 Manzil") {
        bot('sendLocation', [
            'chat_id' => $cid,
            'latitude' => 40.477740,
            'longitude' => 68.777686,
            'reply_markup' => $keys,
        ]);
    }


    // Kurs haqida ma'lumot
    if ($tx == "🎓 Kurslar") {
        bot('sendMessage', [
            'chat_id' => $cid,
            'text' => "*Aynan qaysi yo'nalishdagi kursimiz haqida ma'lumot kerak ?*",
            'parse_mode' => 'markdown',
            'reply_markup' => $kurs,
        ]);
    }

    if ($tx == "📋Kompyuter savodxonligi") {
        bot('sendPhoto', [
            'chat_id' => $cid,
            'photo' => 'https://eduadmin.it-park.uz//storage/images/itccourses/normal/2OhkPvyGvkAydWEtUbdKwVW1u8dhJaSiaCQMT9ua.jpg',
            'caption' => "*🧑‍💻 Kompyuter savodxonligi* \n *📚 Kompyuter bilimlarini noldan eng yuqorigacha koʻtarish!*\n\n*⏳ Davomiyligi: 1 oy*\n*💳 Narxi: 100 000 oy*",
            'parse_mode' => 'markdown',
            'reply_markup' => $kurs,
        ]);
    }

    if ($tx == "🖥 Frontend dasturlash") {
        bot('sendPhoto', [
            'chat_id' => $cid,
            'photo' => 'https://eduadmin.it-park.uz//storage/images/itccourses/normal/hp2oxwxaVrdwBMp2w9plu0tRiLj0nD62ki24F7ZP.jpg',
            'caption' => "*📝 Frontend dasturlash*\n\n*📚 HTML, CSS, JavaScript, jQuery va Bootstrap bilan ishlashni o’rganib, biz bilan veb-dasturchi darajasiga yeting*\n\n ⏳ Davomiyligi: 3-9 oy",
            'parse_mode' => 'markdown',
            'reply_markup' => $kurs,
        ]);
    }

    if ($tx == "💻 Backend dasturlash") {
        bot('sendPhoto', [
            'chat_id' => $cid,
            'photo' => 'https://eduadmin.it-park.uz//storage/images/itccourses/normal/4xk8dFw1MX8FwgSMamtwK9wDD0K75ZRPIocRUhnp.jpg',
            'caption' => "*📝 Backend dasturlash*\n\n📚 *Backend  (server tomoni) deb nomlanadi, bu veb-saytning siz ko'rmaydigan va o'zaro ishlamaydigan qismidir. Bu kursimizda dasturlash, veb-ilovalar, interfeyslarni yaratish, serverlarni sozlash va boshqalarni o'rgansiz*\n\n⏳ Davomiyligi: 3-9 oy",
            'parse_mode' => 'markdown',
            'reply_markup' => $kurs,
        ]);
    }

    if ($tx == "🏙 Grafik dizayn") {
        bot('sendPhoto', [
            'chat_id' => $cid,
            'photo' => 'https://eduadmin.it-park.uz//storage/images/itccourses/normal/m9edp32eAJzh6FLcr413WUVtXbqLbL5z6Hujr7nH.jpg',
            'caption' => "*📝 Grafik dizayn*\n 📚 Adobe Photoshop, Illustrator va boshqa grafik dasturlardan foydalanishni oʻrganish.\n\n ⏳ Davomiyligi: 3-6 oy",
            'parse_mode' => 'markdown',
            'reply_markup' => $kurs,
        ]);
    }

    if ($tx == "📚 IT-English") {
        bot('sendPhoto', [
            'chat_id' => $cid,
            'photo' => 'https://eduadmin.it-park.uz//storage/images/itccourses/normal/xh05P3jCPDEd8QWUNL4Vg0bXsgSigO0aXeFlNjNd.jpg',
            'caption' => "*📝 IT-English*\n*📚 IT jarayonlarni tushunish uchun maxsus ingliz tili.*\n\n *⏳ Davomiyligi: 3-6 oy*",
            'parse_mode' => 'markdown',
            'reply_markup' => $kurs,
        ]);
    }

    if ($tx == "🤖 Mobil robototexnika") {
        bot('sendPhoto', [
            'chat_id' => $cid,
            'photo'=>'https://eduadmin.it-park.uz//storage/images/itccourses/normal/DGpmB8At18UYt41Wok9YDpiM3B44R8npuEOYJpo1.jpg',
            'caption' => "*📝 Mobil robototexnika*\n*📚 Robotlar yaratish jarayoni va ularni dasturlash!*\n\n*⏳ Davomiyligi: 3-6 oy*",
            'parse_mode' => 'markdown',
            'reply_markup' => $kurs,
        ]);
    }

    if ($tx == "🔙 Ortga qaytish") {
        bot('sendMessage', [
            'chat_id' => $cid,
            'text' => "Sizga qanday yordam bera olishim mumkin?",
            'parse_mode' => 'markdown',
            'reply_markup' => $keys,
        ]);
    }

    // register uchun
    if($tx == "📝 Ro'yxatdan o'tish"){
        bot('sendMessage', [
            'chat_id' => $cid,
            'text' => "👤  Familiya Ism Sharifingizni kiriting:\n(Masalan : Bahodirov Elbek Yorqin o'g'li)",
            'parse_mode' => 'markdown',
            'reply_markup' => $otmen,
        ]);
        pstep($cid,"0");
        put("step/$cid.menu","register");
    }

    if($step == "0" and $menu == "register"){
        if($tx == $otex){}else{
            bot('sendMessage', [
                'chat_id' => $cid,
                'text' => "📅 Tug'ilgan yilingiz:\n(Masalan : 15.12.2000)",
                'parse_mode' => 'markdown',
                'reply_markup' => $otmen,
            ]);
        nextTx($cid, "🎓 FISH: ". $tx);
        step($cid);
        }
    }

    if($step == "1" and $menu == "register"){
        if($tx == $otex){}else{
            bot('sendMessage', [
                'chat_id' => $cid,
                'text' => "Qaysi yo'nalish bo'yicha tahsil olmoqchisiz?\n(Tanlang yoki yozing:)",
                'parse_mode' => 'markdown',
                'reply_markup' => $kurslar,
            ]);
        nextTx($cid, "📅 Tug'ilgan yili: ".$tx);
        step($cid);
        }
    }

    if($step == "2" and $menu == "register"){
        if($tx == $otex){}else{
            bot('sendMessage', [
                'chat_id' => $cid,
                'text' => "👉 Tumaningizni tanlang:",
                'parse_mode' => 'markdown',
                'reply_markup' => $tumanlar,
            ]);
            nextTx($cid, "📚 Texnologiya: ".$tx);
            step($cid);
        }
    }

    if($step == "3" and $menu == "register"){
        bot('sendMessage', [
                'chat_id' => $cid,
                'text' => "Telefon raqamingizni yuboring:",
                'parse_mode' => 'markdown',
                'reply_markup' => $phone,
            ]);
        nextTx($cid, "👉 Tuman: ".$tx);
        step($cid);
    }
    $contact = $message->contact;
    $phone_number = $contact->phone_number;
    if($step == "4" and $menu == "register" and $contact){
        if($tx == $otex){}else{

            bot('sendMessage', [
                    'chat_id'=>$cid,
                    'text'=>"*Ma'lumotlar muvaffaqiyatli saqlandi*, Iltimos bot faoliyatini baholang?",
                    'parse_mode'=>'markdown',
                    'reply_markup' => $manzil,
                ]);
                nextTx($cid, "📞 Aloqa: ".$phone_number);
                step($cid);
        }
    }

    if(isset($data) and $stepe == "5" and $menue == "register"){
        ACL($ida);
        $baza = file_get_contents("step/$cbid.txt");
        bot('sendMessage',[
            'chat_id'=>$cbid,
            'text'=>"<b>Sizning Anketa tayyor bo'ldi, barchasi ma'lumotlaringiz tasdiqlaysizmi?</b>
            $baza\n☑️ Bot faoliyati : $data",
            'parse_mode'=>'html',
            'reply_markup'=>$tasdiq,
        ]);
        nextTx($cbid, "👌 Bot faoliyati: ".$data);
        step($cbid);
    }

    if($data == "ok" and $stepe == "6" and $menue == "register"){
        ACL($ida);
        $baza = file_get_contents("step/$cbid.txt");
        bot('sendMessage',[
            'chat_id'=>$admin,
            'text'=>"Yangi o'quvchi!\n🙎‍♂️Username: @$cbuser\n👤 Avvalgi <a href='tg://user?id=$cbid'>Zaxira profili</a>$baza",
            'parse_mode'=>'html',
        ]);
        bot('sendMessage',[
            'chat_id'=>$cbid,
            'text'=>"✅ Sizning Anketangiz xodimlarimizga muvaffaqiyatli jo'natildi, qisqa fursatlarda sizga aloqaga chiqamiz! E'tiboringiz uchun rahmat",
            'parse_mode'=>'html',
            'reply_markup'=>$keys,
        ]);
        del($cbid);
    }



    if($tx == $otex or $data == "clear"){
    ACL($ida);
    del($cbid);
    del($cid);
    if(isset($tx)) $url = "$cid";
    if(isset($data)) $url = "$cbid";
    bot('sendMessage', [
    'chat_id'=>$url,
    'text'=>"Anketa bekor qilindi!",
    'reply_markup'=>$keys,
    ]);
    }

?>