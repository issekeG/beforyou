<?php

namespace App\Controller\Admin;

use App\Entity\Student;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StudentCrudController extends AbstractCrudController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Student::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Gestion des candidats')
            ->setDefaultSort(['lastname' => 'ASC'])
            ->showEntityActionsInlined()
            ->setSearchFields(['firstname', 'lastname', 'email', 'telephone'])
            ->setPaginatorPageSize(30);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstname', 'Prénom'),
            TextField::new('lastname', 'Nom'),
            TextField::new('sex', 'Sexe'),
            AssociationField::new('formation', 'Formation'),
            TextField::new('nationality', 'Nationalité'),
            TextField::new('schoolLevel', "Niveau d'étude"),
            TextField::new('activityActuelle', "Activité actuelle"),
            TextField::new('country', "Pays"),
            TextField::new('city', "Ville"),
            TextField::new('address', "Adresse"),
            TextField::new('telephone', "Téléphone"),
            TextField::new('email', "E-mail"),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        // Action pour Excel
        $exportExcel = Action::new('exportExcel', 'Excel', 'fa fa-file-excel')
            ->linkToCrudAction('exportToExcel') // Changement ici
            ->setCssClass('btn btn-success')
            ->createAsGlobalAction();

        // Action pour CSV
        $exportCsv = Action::new('exportCsv', 'CSV', 'fa fa-file-csv')
            ->linkToCrudAction('exportToCsv') // Changement ici
            ->setCssClass('btn btn-primary')
            ->createAsGlobalAction();

        return $actions
            ->add(Crud::PAGE_INDEX, $exportExcel)
            ->add(Crud::PAGE_INDEX, $exportCsv);

    }

    public function exportToExcel(): Response
    {
        $students = $this->entityManager->getRepository(Student::class)->findAll();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // En-têtes
        $sheet->setCellValue('A1', 'Prénom');
        $sheet->setCellValue('B1', 'Nom');
        $sheet->setCellValue('C1', 'Sexe');
        $sheet->setCellValue('D1', 'Nationalité');
        $sheet->setCellValue('E1', "Formation");
        $sheet->setCellValue('F1', "Niveau d'étude");
        $sheet->setCellValue('G1', "Activité actuelle");
        $sheet->setCellValue('H1', "Pays");
        $sheet->setCellValue('I1', "Ville");
        $sheet->setCellValue('J1', "Adresse");
        $sheet->setCellValue('K1', "Téléphone");
        $sheet->setCellValue('L1', "E-mail");

        // Données
        $row = 2;
        foreach ($students as $student) {
            $sheet->setCellValue('A'.$row, $student->getFirstname());
            $sheet->setCellValue('B'.$row, $student->getLastname());
            $sheet->setCellValue('C'.$row, $student->getSex());
            $sheet->setCellValue('D'.$row, $student->getNationality());
            $sheet->setCellValue('E'.$row, $student->getFormation());
            $sheet->setCellValue('F'.$row, $student->getSchoolLevel());
            $sheet->setCellValue('G'.$row, $student->getActivityActuelle());
            $sheet->setCellValue('H'.$row, $student->getCountry());
            $sheet->setCellValue('I'.$row, $student->getCity());
            $sheet->setCellValue('J'.$row, $student->getAddress());
            $sheet->setCellValue('K'.$row, $student->getTelephone());
            $sheet->setCellValue('L'.$row, $student->getEmail());
            $row++;
        }

        // Auto-size des colonnes
        for ($col = 'A'; $col <= 'K'; $col++) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $tempFile = tempnam(sys_get_temp_dir(), 'students_export_');
        $writer->save($tempFile);

        $response = $this->file(
            $tempFile,
            'candidats_export_' . date('Y-m-d') . '.xlsx',
            ResponseHeaderBag::DISPOSITION_ATTACHMENT
        );
        $response->deleteFileAfterSend(true);

        return $response;
    }

    public function exportToCsv(): StreamedResponse
    {
        $response = new StreamedResponse(function () {
            $handle = fopen('php://output', 'w+');

            // En-têtes
            fputcsv($handle, [
                'Prénom',
                'Nom',
                'Sexe',
                'Nationalité',
                'Formation',
                "Niveau d'étude",
                'Activité actuelle',
                'Pays',
                'Ville',
                'Adresse',
                'Téléphone',
                'E-mail',
            ], ';');

            // Données
            $students = $this->entityManager->getRepository(Student::class)->findAll();
            foreach ($students as $student) {
                fputcsv($handle, [
                    $student->getFirstname(),
                    $student->getLastname(),
                    $student->getSex(),
                    $student->getNationality(),
                    $student->getFormation(),
                    $student->getSchoolLevel(),
                    $student->getActivityActuelle(),
                    $student->getCountry(),
                    $student->getCity(),
                    $student->getAddress(),
                    $student->getTelephone(),
                    $student->getEmail(),
                ], ';');
            }

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="candidats_export_' . date('Y-m-d') . '.csv"');

        return $response;
    }
}