<?php

namespace ProcessMaker\Templates;

use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use ProcessMaker\Http\Controllers\Api\ExportController;
use ProcessMaker\Models\Process;
use ProcessMaker\Models\ProcessCategory;
use ProcessMaker\Models\ProcessTemplates;
use ProcessMaker\Models\ProcessTemplates as Templates;
use SebastianBergmann\CodeUnit\Exception;

class ProcessTemplate implements TemplateInterface
{
    public function save($request) : Response
    {
        $processId = $request->id;
        $name = $request->name;
        $description = $request->description;
        $category = $request->process_template_category_id;
        $mode = $request->mode;

        // Get process manifest
        $manifest = $this->getManifest('process', $processId);
        $rootUuid = $manifest->getData()->root;
        $export = $manifest->getData()->export;
        $svg = $export->$rootUuid->attributes->svg;

        // Discard ALL assets/dependents
        if ($mode === 'discard') {
            $manifest = json_decode(json_encode($manifest), true);
            $rootExport = Arr::first($manifest['original']['export'], function ($value, $key) use ($rootUuid) {
                return $key === $rootUuid;
            });
            data_set($rootExport, 'dependents.*.discard', true);
            data_set($manifest, 'original.export', $rootExport);
        }

        if (ProcessTemplates::where('name', $name)->exists()) {
            // TODO: If same asset has been Saved as Template previously, offer to choose between “Update Template” and “Save as New Template”
            throw new \Exception('Process Template with the same name already exists');
        }

        $model = Templates::firstOrCreate([
            'name' => $name,
            'description' => $description,
            'manifest' => json_encode($manifest),
            'svg' => $svg,
            'process_id' => $processId,
            'process_template_category_id' => null,
        ]);

        return response(['model' => $model]);
    }

    public function view() : bool
    {
        dd('PROCESS TEMPLATE VIEW');
    }

    public function edit() : bool
    {
        dd('PROCESS TEMPLATE EDIT');
    }

    public function destroy() : bool
    {
        dd('PROCESS TEMPLATE DESTROY');
    }

    public function getManifest(string $type, int $id) : object
    {
        $response = (new ExportController)->manifest($type, $id);
        // $manifest = $response->getData();

        return $response;
    }
}
