<?php

namespace App\Http\Controllers\Admin;

use App\Archive;
use App\Images ;
use App\ArchiveGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use GlobalClass;

class ArchiveController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* List All Function Group */

    public function index(Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);
        if ($r->has('key')) {
            $key = $r->key;
        } else {
            $key = '';
        }

        $data['archive'] = ArchiveGroup::where('name', 'like', '%'.$key.'%')->paginate(20);
        return view('admin.archivegroup.index', $data);
    }

    public function create()
    {
        GlobalClass::Roleback(['Customer Service']);
        return view('admin.archivegroup.create');
    }

    public function store(Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);
        /*Validation Store*/
        $this->validate($r, [
        'name'=>'required',
        'desc'=>'required'
      ]);

        $archiveGroup = new ArchiveGroup();

        $slug = str_slug($r->name, "-");

        $count = DB::table('group_archive')->where('slug', $slug)->count();
        if ($count > 0) {
            $count = DB::table('group_archive')->where('slug', 'LIKE', $slug.'%')->count();
        }

        $archiveGroup->desc = $r->desc;
        $archiveGroup->name = $r->name;
        $archiveGroup->slug = $count ? "{$slug}-{$count}" : $slug;

        $archiveGroup->save();

        /*Success Message*/
        $r->session()->flash('success', 'Archive Successfully Added');
        return redirect(route('archive'));
    }

    public function edit($id)
    {
        GlobalClass::Roleback(['Customer Service']);
        try {
            $archiveGroup = ArchiveGroup::findOrFail($id);
            $data['archive'] = $archiveGroup;
            return view('admin.archivegroup.edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('archive');
        }
    }

    public function update($id, Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);

        /*Validation Update*/
        $this->validate($r, [
        'name'=>'required'
      ]);

        /* Save DB */
        $archiveGroup = ArchiveGroup::find($id);
        $archiveGroup->name = $r->name;
        $archiveGroup->desc = $r->desc;
        $archiveGroup->save();

        /*Success Message*/
        $r->session()->flash('success', 'Archive Successfully Modified');
        return redirect(route('archive'));
    }

    public function delete(Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);

        $count = Archive::where('id_group', $r->id)->count();
        if ($count == 0) {
            /*Delete Data*/
            ArchiveGroup::where('id', $r->id)->delete();
            /*Success Message*/
            $r->session()->flash('success', 'Archive Successfully Deleted');
        } else {
            /*Failed Message*/
            $r->session()->flash('success', 'Please remove your items archive');
        }
        return redirect(route('archive'));
    }


    /* List All Function items */

    public function itemArchive(Request $r, $groupID)
    {
        GlobalClass::Roleback(['Customer Service']);
        if ($r->has('key')) {
            $key = $r->key;
        } else {
            $key = '';
        }
        $count = ArchiveGroup::find($groupID);
        if ($count) {
            $data['archive'] = Archive::where('id_group', $groupID)
        ->where('title', 'like', '%'.$key.'%')
        ->paginate(20);
            return view('admin.archive.index', $data);
        }
        return redirect(route('archive'));
    }

    public function itemCreate(Request $r, $groupID)
    {
        $count = ArchiveGroup::find($groupID);
        if ($count) {
            GlobalClass::Roleback(['Customer Service']);
            return view('admin.archive.create');
        }
        return redirect(route('archive'));
    }

    public function itemStore(Request $r)
    {
        $count = ArchiveGroup::find($r->idgroup);
        if ($count) {
            GlobalClass::Roleback(['Customer Service']);

            /*Validation Store*/
            $this->validate($r, [
                'title'=>'required|max:100',
          'attachments'=>'required|mimes:jpeg,png,pdf,xls,xlsx,doc,docx',
          'publish_date'=>'required',
          'desc'=>''
            ]);


            /* Upload */
            $filename = GlobalClass::UploadFile([
                'path'=>'uploaded/download',
                'files'=> $r->file('attachments')
            ]);

            /* Save DB */
            $images = new Images();
            $images->id_albums = 0;
            $images->file_name = $filename;
            $images->dir = 'download';
            $images->save();

            $data = array(
          'title'=>$r->title,
          'id_group'=>$r->idgroup,
          'desc'=>$r->desc==''?'':$r->desc,
          'tag'=>$r->tags==''?'-':$r->tags,
          'file'=>$filename,
          'published'=>$r->publish_date
        );
            $archive = new Archive();
            $archive->insert($data);

            /*Success Message*/
            $r->session()->flash('success', 'Attachments Successfully Added');
            return redirect(route('item_archive', ['id'=>$r->idgroup]));
        }
        return redirect(route('archive'));
    }

    public function itemEdit($id)
    {
        GlobalClass::Roleback(['Customer Service']);
        try {
            $archive = Archive::findOrFail($id);
            $data['size'] = GlobalClass::formatSizeUnits(filesize(public_path('uploaded/download/'.$archive->file)));
            $data['archive'] = $archive;
            return view('admin.archive.edit', $data);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('archive');
        }
    }

    public function itemUpdate($id, Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);
        $archive = Archive::find($id);
        if ($r->attachments) {
            $this->validate($r, [
          'title'=>'required|max:100',
          'tags'=>'max:50',
          'attachments.*'=>'required|mimes:jpeg,png,pdf,xls,xlsx,doc,docx',
          'publish_date'=>'required'
        ]);

            /* Remove old files */
            $old = DB::table('archive')->where('id', $id)->first();
            Images::where('file_name', $old->file)->delete();
            GlobalClass::removeFile([
                array(
                    'path'=>'uploaded/download',
                    'files'=>$old->file
                ),
            ]);

            /* Upload */
            $filename = GlobalClass::UploadFile([
                'path'=>'uploaded/download',
                'files'=> $r->file('attachments')
            ]);

            /* Save DB */
            $images = new Images();
            $images->id_albums = 0;
            $images->file_name = $filename;
            $images->dir = 'download';
            $images->save();

            $archive->file = $filename;
        }

        $archive->title = $r->title;
        $archive->desc = $r->desc==''?'':$r->desc;
        $archive->tag = $r->tags==''?'-':$r->tags;
        $archive->published = $r->publish_date;
        $archive->update();

        /*Success Message*/
        $r->session()->flash('success', 'Attachments Successfully Update');
        return redirect(route('item_archive', ['id'=>$archive->id_group]));
    }

    public function itemDelete(Request $r)
    {
        GlobalClass::Roleback(['Customer Service']);

        /*Delete Data*/
        Archive::where('id', $r->id)->delete();

        /*Success Message*/
        $r->session()->flash('success', 'Attachments Successfully Deleted');
        return redirect()->back();
    }
}
