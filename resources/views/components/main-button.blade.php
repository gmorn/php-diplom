<style>
  .custom-button {
    padding: 10px 15px;
    background: none;
    border: none;
    border-radius: 12px;
    font-weight: 500;
    font-size: 14px;
    transition: box-shadow 300ms;
    cursor: pointer;
  }

  .custom-button:hover {
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.15);
  }
</style>

<button type="{{$type}}" class="custom-button">{{$content}}</button>