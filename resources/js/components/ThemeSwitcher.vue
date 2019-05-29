<template>
    <div>
        <button
                v-for="(color, t) in themes"
                class="rounded-full w-4 h-4 mr-2 border focus:outline-none"
                :class="[color, {'border-blue-500': theme === t}]"
                @click="toggle(t)"
        ></button>
    </div>
</template>

<script>
  export default {
    props: {
      default: {
        type: String,
        default: 'theme-light',
      },

      storageKey: {
        type: String,
        default: 'theme',
      },

      themes: {
        type: Object,
        default: () => ({
          'theme-light': 'bg-white',
          'theme-dark': 'bg-gray-900',
        })
      }
    },

    data() {
      return {
        theme: null,
      };
    },

    watch: {
      theme(current, previous) {
        document.body.classList.remove(previous);
        document.body.classList.add(current);
      },
    },

    created() {
      this.theme = localStorage.getItem(this.storageKey) || this.default;
    },

    methods: {
      toggle(theme) {
        this.theme = theme;
        this.remember(theme);
      },

      remember(theme) {
        localStorage.setItem(this.storageKey, theme);
      },
    }
  };
</script>
