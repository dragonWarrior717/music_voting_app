<template>
  <div class="vote-buttons">
    <button 
      class="vote-btn upvote"
      :class="{ active: value === 1 }"
      @click="$emit('upvote')"
      title="Upvote"
    >
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 4l8 8h-4v8h-8v-8h-4l8-8z" :fill="value === 1 ? '#FFD700' : 'none'" />
      </svg>
    </button>
    
    <span 
      class="votes-count" 
      :class="{ 
        'positive': votesCount > 0,
        'negative': votesCount < 0
      }"
      :title="`👍 ${upvotes} upvotes\n👎 ${downvotes} downvotes\n= ${votesCount} total`"
    >
      {{ votesCount > 0 ? '+' : '' }}{{ votesCount }}
    </span>
    
    <button 
      class="vote-btn downvote"
      :class="{ active: value === -1 }"
      @click="$emit('downvote')"
      title="Downvote"
    >
      <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 20l-8-8h4v-8h8v8h4l-8 8z" :fill="value === -1 ? '#000000' : 'none'" />
      </svg>
    </button>
  </div>
</template>

<script setup lang="ts">
defineProps<{
  value?: number | null;
  votesCount: number;
  upvotes: number;
  downvotes: number;
}>();

defineEmits<{
  (e: 'upvote'): void;
  (e: 'downvote'): void;
}>();
</script>

<style lang="scss" scoped>
.vote-buttons {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 1rem;
  width: 80%;
  margin: 0 auto;
  background-color: #e3f2fd;
  padding: 0.75rem;
  border-radius: 8px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);

  .vote-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.25rem;
    color: #666;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;

    &:hover {
      transform: scale(1.1);
    }

    &.active {
      &.upvote {
        color: #666;
      }

      &.downvote {
        color: #666;
      }
    }

    svg {
      transition: all 0.2s;
    }
  }

  .votes-count {
    min-width: 3rem;
    text-align: center;
    font-weight: bold;
    font-size: 1.1rem;
    color: #666;
    cursor: help;

    &.positive {
      color: #28a745;
    }

    &.negative {
      color: #dc3545;
    }
  }
}
</style> 