<template>
  <div>
    <b-button :aria-label="createProcess" v-b-modal.selectTemplate class="mb-3 mb-md-0 ml-md-2">
      <i class="fas fa-plus"/> {{ process }}
    </b-button>
    <modal
      id="selectTemplate"
      size="huge"
      :title="title"
      :subtitle="subtitle"
      :hasHeaderButtons="hasHeaderButtons"
      :headerButtons="headerButtons"
      :hasTitleButtons="hasTitleButtons"
      :titleButtons="titleButtons"
      :hide-footer="true"
      @showSelectTemplate="showSelectTemplateComponent"
      @createBlankProcess="createBlankProcess"
      @useSelectedTemplate="useSelectedTemplate"
      @ok.prevent="onSubmit"
      @close="close"
    >
      <template-search :type="type" :component="currentComponent" @show-details="updateModal($event)" 
        @blank-process-button-clicked="createBlankProcess()"
        @ai-process-button-clicked="createAiProcess()"
        :package-ai="packageAi" />
    </modal>
    <create-process-modal ref="create-process-modal" :blank-template="blankTemplate" :count-categories="countCategories" :selected-template="selectedTemplate" :template-data="templateData" @resetModal="resetModal()"/>
  </div>
</template>

<script>
  import { Modal } from "SharedComponents";
  import TemplateSearch from "./TemplateSearch.vue";
  import CreateProcessModal from "../../processes/components/CreateProcessModal.vue";

  export default {
    components: { Modal, TemplateSearch, CreateProcessModal },
    props: ['type', 'countCategories', 'packageAi'],
    data: function() {
      return {
        title: '',
        showHelper: true,
        currentComponent: 'template-select-card',
        hasTitleButtons: true,
        hasHeaderButtons: false,
        headerButtons: [
          {'content': '< Back', 'action': 'showSelectTemplate', 'variant': 'link', 'disabled': false, 'hidden': true, 'ariaLabel': 'Back to select templates'},
        ],
        titleButtons: [
          {'content': 'Use Template', 'action': 'useSelectedTemplate', 'variant': 'primary', 'disabled': false, 'hidden': true, 'position': 'right', 'ariaLabel': `Create a ${this.type} with this template` },
        ],
        blankTemplate: false,
        selectedTemplate: false,
        templateData: {},
      }
    },
    computed: {
      subtitle() {
        return this.$t(`Create a new ${this.type}.`);
      },
      createProcess() {
        return this.$t('Create Process');
      },
      process() {
        return this.$t('Process');
      }
    },
    methods: {
      updateModal($event) {
        this.templateData = $event;
        this.title = $event.name;
        this.hasHeaderButtons = true;
        this.headerButtons[0].hidden = false;
        this.titleButtons[0].hidden = false;
        this.currentComponent = 'template-details';
      },
      showSelectTemplateComponent() {
        this.currentComponent = 'template-select-card';
        this.headerButtons[0].hidden = true;
        this.titleButtons[0].hidden = true;
        this.hasHeaderButtons = false;
        this.title = this.$t(`New ${this.type}`);
      },
      createBlankProcess() {
        this.selectedTemplate = false;
        this.blankTemplate = true;
        this.$bvModal.hide("selectTemplate");
        this.$refs["create-process-modal"].show();
      },
      createAiProcess() {
        window.location.href = "/package-ai/processes/create";
      },
      useSelectedTemplate() {
        this.selectedTemplate = true;
        this.blankTemplate = false;
        this.$bvModal.hide("selectTemplate");
        this.showSelectTemplateComponent();
        this.$refs["create-process-modal"].show();
      },
      close() {
        this.$bvModal.hide("selectTemplate");
        this.showSelectTemplateComponent();
      },
      resetModal() {
        this.selectedTemplate = false;
        this.templateData = {};
      }
    },
    mounted() {
      this.title = this.$t(`New ${this.type}`);
    }
  };
</script>

<style scoped>

</style>