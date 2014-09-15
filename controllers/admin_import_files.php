<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Import/Export Module -> Import
 *
 * @author      Zac vineyard
 * @website     http://zacvineyard.com
 * @package     PyroCMS
 * @subpackage  Import/Export Module
 */
class Admin_import_files extends Admin_Controller
{
    /**
     * The current active section
     * @access protected
     * @var string
     */
    protected $section = 'import_files';

    public function __construct()
    {
        parent::__construct();

        // Load all the required classes
        $this->load->library('form_validation');
        $this->lang->load('ie');
        $this->load->model('import_m');
    }

    /**
     * Upload a PyroCMS XML export file
     */
    public function index()
    {
        // XML Upload
        $this->template->title($this->module_details['name'])->build('admin/import_files');
    }

    public function upload()
    {
        $config['upload_path'] = 'uploads/'.SITE_REF.'/import_export';
        $config['allowed_types'] = 'xml';
        $config['remove_spaces'] = true; 
        $config['overwrite'] = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload())
        {
            $this->session->set_flashdata('error', lang('ie:upload_error'));
            redirect('admin/'.$this->module_details['slug'].'/import_files');
        }
        else
        {
            $data = $this->upload->data();
            $this->parse($data['file_name']);
        }
    }

    public function parse($file)
    {
        $xml = file_get_contents('uploads/'.SITE_REF.'/import_export/'.$file);
        $obj = simplexml_load_string($xml);

        foreach($obj as $files => $file)
        {
            $insert_data[] = array(
                'id' => (string) $file->id,
                'folder_id' => (int) $file->folder_id,
                'user_id' => (int) $file->user_id,
                'type' => (string) $file->type,
                'name' => (string) $file->name,
                'filename' => (string) $file->filename,
                'path' => (string) $file->path,
                'description' => (string) $file->description,
                'extension' => (string) $file->extension,
                'mimetype' => (string) $file->mimetype,
                'keywords' => (string) $file->keywords,
                'width' => (int) $file->width,
                'height' => (int) $file->height,
                'filesize' => (int) $file->filesize,
                'alt_attribute' => (string) $file->alt_attribute,
                'download_count' => (int) $file->download_count,
                'date_added' => (int) $file->date_added,
                'sort' => (int) $file->sort
            );
        }

        if(!$this->db->insert_batch('files',$insert_data))
        {
            $this->session->set_flashdata('error', lang('ie:import_error'));
            redirect('admin/'.$this->module_details['slug'].'/import_files');
        }

        // Redirect
        $this->session->set_flashdata('success', lang('ie:import_success'));
        redirect('admin/'.$this->module_details['slug'].'/import_files');

    }
}
