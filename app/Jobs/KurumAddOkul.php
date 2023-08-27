<?php

namespace App\Jobs;

use App\Models\kurumLogModel;
use App\Models\kurumModel;
use App\Models\kurumOkulModel;
use App\Models\kurumUserModel;
use App\Models\LogModel;
use App\Models\Okul;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use phpDocumentor\Reflection\Types\Void_;

class KurumAddOkul implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Kurumun üzerine okul alma
     *
     * @return void
     */
    public function handle(Request $request)
    {
        $this->validation($request);
        $okul = Okul::find($request->okul_id);
        kurumOkulModel::create([
            'okul_id' => $okul->id,
            'kurum_id' => get_current_kurum()->id,
        ]);
        $this->log($okul);
    }

    /**
     * Kurumun üzerine okul alması için validation
     *
     * @param Request $request
     * @return void
     */
    public function validation(Request $request)
    {
        if (!$request->okul_id)
            throw new Exception("Okul Bulunamadı");
        if (!$okul = Okul::find($request->okul_id))
            throw new Exception("Okul Bulunamadı");
        if (!$kurumiliski = kurumUserModel::where('user_id', auth()->user()->id)->first())
            throw new Exception("Kurum Bulunamadı");
        if (!$kurum = kurumModel::find($kurumiliski->kurum_id))
            throw new Exception("Kurum Bulunamadı");
        if (kurumOkulModel::where('okul_id', $okul->id)->where('kurum_id', $kurum->id)->first())
            throw new Exception("Bu okul eklenmiş durumda");
    }

    /**
     * Kurumun üzerine okul aldığı zaman olan loglama
     *
     * @return void
     */
    public function log($okul)
    {
        $logUser = auth()->user();
        $logText = "Kurum Yetkilisi $logUser->ad $logUser->soyad ($logUser->ozel_id), '$okul->ad' adlı okulu kurum üzerine aldı.";
        LogModel::create(['kategori_id' => 15, 'logText' => $logText]);
        $kurumlogText = "$logUser->ad $logUser->soyad ($logUser->ozel_id), '$okul->ad' adlı okulu kurum üzerine aldı.";
        kurumLogModel::create(['kategori_id' => 10, 'logText' => $kurumlogText, 'kurum_id' => get_current_kurum()->id]);
    }
}
