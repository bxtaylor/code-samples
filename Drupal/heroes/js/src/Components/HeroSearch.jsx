import React, { Component } from 'react';

class HeroSearch extends Component {

  constructor(props) {
    super(props);
    this.state = {searchInput: ''};
    this.handleClick = this.handleClick.bind(this);
    this.handleChange = this.handleChange.bind(this);
    this.handleKeyDown = this.handleKeyDown.bind(this);
  }

  /**
   * Watches the changes to the text input
   * and stores them in the state object
   * for later use.
   *
   * @param event
   *   The event handler.
   */
  handleChange(event) {
    this.setState({searchInput: event.target.value});
  }

  /**
   * Handles the Enter key down event and triggers the
   * searchHeroes function from the parent component.
   *
   * @param event
   *   Event handler.
   */
  handleKeyDown(event) {
    if (event.key === 'Enter') {
      this.props.searchHeros(this.state.searchInput);
    }
  }

  /**
   * Handles the click event on the submit button and
   * triggers the searchHeroes function from the parent component.
   */
  handleClick() {
    this.props.searchHeroes(this.state.searchInput);
  }

  render() {
    return (
      <div>
        <input onKeyDown={this.handleKeyDown} onChange={this.handleChange} type="text" placeholder="search superheroes"/>
        <button onClick={this.handleClick} className="button button--primary">Submit</button>
      </div>
    )
  }
}

export default HeroSearch;
