<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use PDF;

class ResumeController extends Controller
{
    /**
     * Show the resume page.
     *
     * @param Request $request
     * @return array|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function resume(Request $request)
    {
        return view('resume')
            ->with('title_prefix', 'Resume');
    }

    public function getGameCollectingResume(Request $request)
    {
        // Special HTTP get variable to download the resume as a PDF.
        if($request->input('download')) {
            $pdf = PDF::loadView('collection_item_label', [
                'collectionItem' => $collectionItem,
            ]);

            $customPaper = array(0, 0, 225, 150);
            $pdf->setPaper($customPaper);

            $label_filename = $collectionItem->sku . '.pdf';

            // Return the PDF label. It can either be downloaded or streamed.
//        if($request->input('download')) {
//            return $pdf->download($label_filename);
//        }
            if($request->input('stream')) {
                return $pdf->stream($label_filename);
            }
//        return $pdf->stream($label_filename);
            return $pdf->download($label_filename);
        }

        return view('resume__gamecollecting');
    }

}
