<?php
namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Modules\Contact\Entities\Contact;

class ContactImport implements ToModel
{

    public function model(array $row)
    {
        return new Contact([
            'name'     => $row[0],
            'phone'    => $row[1],
            'whatsapp'    => $row[1],
        ]);
    }

}
