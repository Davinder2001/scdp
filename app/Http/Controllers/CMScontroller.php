<?php
namespace App\Http\Controllers;

use App\Models\Cms; // Use the correct namespace and model name
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CMScontroller extends Controller
{
   // About Us
   public function cms_about_us(Request $request)
   {
       // Fetch the latest uploaded PDF for about_us type
       $latestPdf = Cms::where('type', 'about_us')->orderBy('created_at', 'desc')->first();

       // Check user role and return the appropriate view
       if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2) {
           return view('CMS.about_us', compact('latestPdf'));
       } else {
           return redirect('dashboard');
       }
   }

   public function importCmsAboutUs(Request $request)
   {
       // Validate if file is present in the request
       if (!$request->hasFile('file')) {
           return back()->with('error', 'Please select a PDF file first!');
       }

       try {
           $file = $request->file('file');

           // Validate file type
           if ($file->extension() !== 'pdf') {
               return back()->with('error', 'The file must be a PDF.');
           }

           // Store the file in a custom directory with a unique name
           $filePath = $file->storeAs('public/uploads/cmss', $file->getClientOriginalName());

           // Delete the old PDF record and file of the same type
           $existingPdf = Cms::where('type', 'about_us')->orderBy('created_at', 'desc')->first();
           if ($existingPdf) {
               // Delete the old PDF file from storage
               Storage::delete($existingPdf->file_path);
               // Delete the old PDF record from the database
               $existingPdf->delete();
           }

           // Save new PDF information in the database using the Cms model
           $cms = new Cms();
           $cms->type = 'about_us';
           $cms->file_name = $file->getClientOriginalName();
           $cms->file_path = $filePath;
           $cms->save();

           return redirect()->back()->with('success', 'PDF file uploaded and saved successfully.');
       } catch (\Exception $e) {
           // Handle any exceptions that occur during the file upload process
           return redirect()->back()->with('error', 'An error occurred while uploading the file: ' . $e->getMessage());
       }
   }


    public function cms_budget_under_scdp(Request $request)
            {
                // Fetch the latest uploaded PDF for cms_budget_under_scdp type
                $latestPdf = Cms::where('type', 'cms_budget_under_scdp')->orderBy('created_at', 'desc')->first();

                // Check user role and return the appropriate view
                if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2) {
                    return view('CMS.budget_under_scdp', compact('latestPdf'));
                } else {
                    return redirect('dashboard');
                }
            }


    public function importCmsBudgetUnderScdp(Request $request)
            {
                // Validate if file is present in the request
                if (!$request->hasFile('file')) {
                    return back()->with('error', 'Please select a PDF file first!');
                }

                try {
                    $file = $request->file('file');

                    // Validate file type
                    if ($file->extension() !== 'pdf') {
                        return back()->with('error', 'The file must be a PDF.');
                    }

                    // Store the file in a custom directory with a unique name
                    $filePath = $file->storeAs('public/uploads/cmss', $file->getClientOriginalName());

                    // Delete the old PDF record and file of the same type
                    $existingPdf = Cms::where('type', 'cms_budget_under_scdp')->orderBy('created_at', 'desc')->first();
                    if ($existingPdf) {
                        // Delete the old PDF file from storage
                        Storage::delete($existingPdf->file_path);
                        // Delete the old PDF record from the database
                        $existingPdf->delete();
                    }

                    // Save new PDF information in the database using the Cms model
                    $cms = new Cms();
                    $cms->type = 'cms_budget_under_scdp';
                    $cms->file_name = $file->getClientOriginalName();
                    $cms->file_path = $filePath;
                    $cms->save();

                    return redirect()->back()->with('success', 'PDF file uploaded and saved successfully.');
                } catch (\Exception $e) {
                    // Handle any exceptions that occur during the file upload process
                    return redirect()->back()->with('error', 'An error occurred while uploading the file: ' . $e->getMessage());
                }
            }


            public function cms_major_works(Request $request)
                {
                    // Fetch the latest uploaded PDF for cms_major_works type
                    $latestPdf = Cms::where('type', 'cms_major_works')->orderBy('created_at', 'desc')->first();

                    // Check user role and return the appropriate view
                    if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2) {
                        return view('CMS.major_works', compact('latestPdf'));
                    } else {
                        return redirect('dashboard');
                    }
                }

            public function importCmsMajorWorks(Request $request)
                {
                    // Validate if file is present in the request
                    if (!$request->hasFile('file')) {
                        return back()->with('error', 'Please select a PDF file first!');
                    }

                    try {
                        $file = $request->file('file');

                        // Validate file type
                        if ($file->extension() !== 'pdf') {
                            return back()->with('error', 'The file must be a PDF.');
                        }

                        // Store the file in a custom directory with a unique name
                        $filePath = $file->storeAs('public/uploads/cmss', $file->getClientOriginalName());

                        // Delete the old PDF record and file of the same type
                        $existingPdf = Cms::where('type', 'cms_major_works')->orderBy('created_at', 'desc')->first();
                        if ($existingPdf) {
                            // Delete the old PDF file from storage
                            Storage::delete($existingPdf->file_path);
                            // Delete the old PDF record from the database
                            $existingPdf->delete();
                        }

                        // Save new PDF information in the database using the Cms model
                        $cms = new Cms();
                        $cms->type = 'cms_major_works';
                        $cms->file_name = $file->getClientOriginalName();
                        $cms->file_path = $filePath;
                        $cms->save();

                        return redirect()->back()->with('success', 'PDF file uploaded and saved successfully.');
                    } catch (\Exception $e) {
                        // Handle any exceptions that occur during the file upload process
                        return redirect()->back()->with('error', 'An error occurred while uploading the file: ' . $e->getMessage());
                    }
                }


            public function cms_schemes_under_scdp(Request $request)
                {
                    // Fetch the latest uploaded PDF for cms_schemes_under_scdp type
                    $latestPdf = Cms::where('type', 'cms_schemes_under_scdp')->orderBy('created_at', 'desc')->first();

                    // Check user role and return the appropriate view
                    if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2) {
                        return view('CMS.schemes_under_scdp', compact('latestPdf'));
                    } else {
                        return redirect('dashboard');
                    }
                }

            public function importCmsSchemesUnderScdp(Request $request)
                {
                    // Validate if file is present in the request
                    if (!$request->hasFile('file')) {
                        return back()->with('error', 'Please select a PDF file first!');
                    }

                    try {
                        $file = $request->file('file');

                        // Validate file type
                        if ($file->extension() !== 'pdf') {
                            return back()->with('error', 'The file must be a PDF.');
                        }

                        // Store the file in a custom directory with a unique name
                        $filePath = $file->storeAs('public/uploads/cmss', $file->getClientOriginalName());

                        // Delete the old PDF record and file of the same type
                        $existingPdf = Cms::where('type', 'cms_schemes_under_scdp')->orderBy('created_at', 'desc')->first();
                        if ($existingPdf) {
                            // Delete the old PDF file from storage
                            Storage::delete($existingPdf->file_path);
                            // Delete the old PDF record from the database
                            $existingPdf->delete();
                        }

                        // Save new PDF information in the database using the Cms model
                        $cms = new Cms();
                        $cms->type = 'cms_schemes_under_scdp';
                        $cms->file_name = $file->getClientOriginalName();
                        $cms->file_path = $filePath;
                        $cms->save();

                        return redirect()->back()->with('success', 'PDF file uploaded and saved successfully.');
                    } catch (\Exception $e) {
                        // Handle any exceptions that occur during the file upload process
                        return redirect()->back()->with('error', 'An error occurred while uploading the file: ' . $e->getMessage());
                    }
                }


            public function cms_sc_population_census_2011(Request $request)
                {
                    // Fetch the latest uploaded PDF for cms_sc_population_census_2011 type
                    $latestPdf = Cms::where('type', 'cms_sc_population_census_2011')->orderBy('created_at', 'desc')->first();

                    // Check user role and return the appropriate view
                    if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2) {
                        return view('CMS.sc_population_census_2011', compact('latestPdf'));
                    } else {
                        return redirect('dashboard');
                    }
                }

            public function importCmsScPopulationCensus2011(Request $request)
                {
                    // Validate if file is present in the request
                    if (!$request->hasFile('file')) {
                        return back()->with('error', 'Please select a PDF file first!');
                    }

                    try {
                        $file = $request->file('file');

                        // Validate file type
                        if ($file->extension() !== 'pdf') {
                            return back()->with('error', 'The file must be a PDF.');
                        }

                        // Store the file in a custom directory with a unique name
                        $filePath = $file->storeAs('public/uploads/cmss', $file->getClientOriginalName());

                        // Delete the old PDF record and file of the same type
                        $existingPdf = Cms::where('type', 'cms_sc_population_census_2011')->orderBy('created_at', 'desc')->first();
                        if ($existingPdf) {
                            // Delete the old PDF file from storage
                            Storage::delete($existingPdf->file_path);
                            // Delete the old PDF record from the database
                            $existingPdf->delete();
                        }

                        // Save new PDF information in the database using the Cms model
                        $cms = new Cms();
                        $cms->type = 'cms_sc_population_census_2011';
                        $cms->file_name = $file->getClientOriginalName();
                        $cms->file_path = $filePath;
                        $cms->save();

                        return redirect()->back()->with('success', 'PDF file uploaded and saved successfully.');
                    } catch (\Exception $e) {
                        // Handle any exceptions that occur during the file upload process
                        return redirect()->back()->with('error', 'An error occurred while uploading the file: ' . $e->getMessage());
                    }
                }


            public function cms_guidelines(Request $request)
                {
                    // Fetch the latest uploaded PDF for cms_guidelines type
                    $latestPdf = Cms::where('type', 'cms_guidelines')->orderBy('created_at', 'desc')->first();

                    // Check user role and return the appropriate view
                    if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2) {
                        return view('CMS.guidelines', compact('latestPdf'));
                    } else {
                        return redirect('dashboard');
                    }
                }

            public function importCmsGuidelines(Request $request)
                {
                    // Validate if file is present in the request
                    if (!$request->hasFile('file')) {
                        return back()->with('error', 'Please select a PDF file first!');
                    }

                    try {
                        $file = $request->file('file');

                        // Validate file type
                        if ($file->extension() !== 'pdf') {
                            return back()->with('error', 'The file must be a PDF.');
                        }

                        // Store the file in a custom directory with a unique name
                        $filePath = $file->storeAs('public/uploads/cmss', $file->getClientOriginalName());

                        // Delete the old PDF record and file of the same type
                        $existingPdf = Cms::where('type', 'cms_guidelines')->orderBy('created_at', 'desc')->first();
                        if ($existingPdf) {
                            // Delete the old PDF file from storage
                            Storage::delete($existingPdf->file_path);
                            // Delete the old PDF record from the database
                            $existingPdf->delete();
                        }

                        // Save new PDF information in the database using the Cms model
                        $cms = new Cms();
                        $cms->type = 'cms_guidelines';
                        $cms->file_name = $file->getClientOriginalName();
                        $cms->file_path = $filePath;
                        $cms->save();

                        return redirect()->back()->with('success', 'PDF file uploaded and saved successfully.');
                    } catch (\Exception $e) {
                        // Handle any exceptions that occur during the file upload process
                        return redirect()->back()->with('error', 'An error occurred while uploading the file: ' . $e->getMessage());
                    }
                }


            public function cms_contact_us(Request $request)
                {
                    // Fetch the latest uploaded PDF for cms_contact_us type
                    $latestPdf = Cms::where('type', 'cms_contact_us')->orderBy('created_at', 'desc')->first();

                    // Check user role and return the appropriate view
                    if (auth()->user()->role_id == 1 || auth()->user()->role_id == 2) {
                        return view('CMS.contact_us', compact('latestPdf'));
                    } else {
                        return redirect('dashboard');
                    }
                }

            public function importCmsContactUs(Request $request)
                {
                    // Validate if file is present in the request
                    if (!$request->hasFile('file')) {
                        return back()->with('error', 'Please select a PDF file first!');
                    }

                    try {
                        $file = $request->file('file');

                        // Validate file type
                        if ($file->extension() !== 'pdf') {
                            return back()->with('error', 'The file must be a PDF.');
                        }

                        // Store the file in a custom directory with a unique name
                        $filePath = $file->storeAs('public/uploads/cmss', $file->getClientOriginalName());

                        // Delete the old PDF record and file of the same type
                        $existingPdf = Cms::where('type', 'cms_contact_us')->orderBy('created_at', 'desc')->first();
                        if ($existingPdf) {
                            // Delete the old PDF file from storage
                            Storage::delete($existingPdf->file_path);
                            // Delete the old PDF record from the database
                            $existingPdf->delete();
                        }

                        // Save new PDF information in the database using the Cms model
                        $cms = new Cms();
                        $cms->type = 'cms_contact_us';
                        $cms->file_name = $file->getClientOriginalName();
                        $cms->file_path = $filePath;
                        $cms->save();

                        return redirect()->back()->with('success', 'PDF file uploaded and saved successfully.');
                    } catch (\Exception $e) {
                        // Handle any exceptions that occur during the file upload process
                        return redirect()->back()->with('error', 'An error occurred while uploading the file: ' . $e->getMessage());
                    }
                }
}
