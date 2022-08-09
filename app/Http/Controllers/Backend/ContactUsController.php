<?php

namespace App\Http\Controllers\Backend;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactUsController extends Controller
{
    public function __construct()
    {
        if (\auth()->check()){
            $this->middleware('auth');
        } else {
            return view('auth.login');
        }
    }

    public function index()
    {
        if (!\auth()->user()->ability('admin', 'manage_contact,show_contact')) {
            return redirect('admin');
        }

        $keyword = (isset(\request()->keyword) && \request()->keyword != '') ? \request()->keyword : null;
        $status = (isset(\request()->status) && \request()->status != '') ? \request()->status : null;
        $sort_by = (isset(\request()->sort_by) && \request()->sort_by != '') ? \request()->sort_by : 'id';
        $order_by = (isset(\request()->order_by) && \request()->order_by != '') ? \request()->order_by : 'desc';
        $limit_by = (isset(\request()->limit_by) && \request()->limit_by != '') ? \request()->limit_by : '10';

        $messages = Contact::query();
        if ($keyword != null) {
            $messages = $messages->search($keyword);
        }
        if ($status != null) {
            $messages = $messages->whereStatus($status);
        }

        $messages = $messages->orderBy($sort_by, $order_by);
        $messages = $messages->paginate($limit_by);

        return view('backend.pages.contact_us.index', compact('messages'));
    }

    public function show(Contact $contact)
    {
        if (!\auth()->user()->ability('admin', 'display_contact')) {
            return redirect('admin');
        }

        return view('backend.pages.contact_us.show', ['message' => $contact]);
    }

    public function destroy(Contact $contact)
    {
        if (!\auth()->user()->ability('admin', 'delete_contact')) {
            return redirect('admin');
        }
            $contact->delete();
            return redirect()->back()->with(['message' => 'Message deleted successfully','alert-type' => 'success',]);
    }
}
