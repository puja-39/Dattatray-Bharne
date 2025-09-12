<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use App\Models\Contractor;

class NodeConnectionsExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths
{
    protected $node_connections;

    public function __construct($node_connections)
    {
        $this->node_connections = $node_connections;
    }

    public function collection()
    {
        return $this->node_connections->map(function ($connection, $index) {
            $contractor = Contractor::find($connection->contractor_id);
            
            $address_parts = [];
            if (!empty($connection->house_number)) $address_parts[] = $connection->house_number;
            if (!empty($connection->house_name)) $address_parts[] = $connection->house_name;
            if (!empty($connection->apartment)) $address_parts[] = $connection->apartment;
            if (!empty($connection->street)) $address_parts[] = $connection->street;
            if (!empty($connection->city_or_village)) $address_parts[] = $connection->city_or_village;
            $full_address = implode(', ', $address_parts);

            return [
                'sr_no' => $index + 1,
                'contractor' => $contractor->name ?? 'N/A',
                'customer_name' => $connection->customer_name ?? 'N/A',
                'pipe_diameter' => $connection->pipe_connection_diameter ?? 'N/A',
                'meter_number' => $connection->meter_number ?? 'N/A',
                'faucet_connection' => $connection->faucet_connection ?? 'N/A',
                'contact_number' => $connection->contact_number ?? 'N/A',
                'address' => $full_address != '' ? $full_address : 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Sr.No.',
            'Contractor',
            'Customer',
            'Pipe Diameter',
            'Meter No.',
            'Faucet Connection',
            'Contact Number',
            'Address',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFE2E2E2'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            // Add borders to all cells
            'A1:H' . ($this->node_connections->count() + 1) => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // Sr.No.
            'B' => 20,  // Contractor
            'C' => 20,  // Customer
            'D' => 15,  // Pipe Diameter
            'E' => 15,  // Meter No.
            'F' => 18,  // Faucet Connection
            'G' => 18,  // Contact Number
            'H' => 40,  // Address
        ];
    }
}
