import React, { Component } from 'react';
import axios from 'axios';
import HeroSearch from "./HeroSearch";

class HeroesList extends Component {

  constructor(props) {
    super(props);
    this.searchHeroes = this.searchHeroes.bind(this);
    this.state = {data: []}
  }

  /**
   * Call the internal API Service controller with the name
   * typed into the input field.
   *
   * @param query
   *   The name to submit to the controller.
   */
  searchHeroes(query) {
    axios.get('http://local.sandbox.com/api/heroes/search/' + encodeURIComponent(query))
      .then(response => {
        // @todo handle when 0 results are returned.
        this.setState({data: response.data.data.results})
      })
      .catch(error => {
        console.log(error)
      })
      .then();
  }

  // @todo turn the table into its own component.
  render() {
    return (
      <>
        <HeroSearch searchHeroes={this.searchHeroes}/>
        <table>
          <thead>
            <tr>
              <td><strong>Name</strong></td>
              <td><strong>Full Name</strong></td>
              <td><strong>Gender</strong></td>
              <td><strong>Race</strong></td>
              <td><strong>Affiliations</strong></td>
              <td><strong>Publisher</strong></td>
            </tr>
          </thead>
          <tbody>
            {this.state.data.map((item, key) =>
              <tr key={key}>
                <td>{item.name}</td>
                <td>{item.biography['full-name']}</td>
                <td>{item.appearance.gender}</td>
                <td>{item.appearance.race}</td>
                <td>{item.connections['group-affiliation']}</td>
                <td>{item.biography.publisher}</td>
              </tr>
            )}
          </tbody>
        </table>
      </>
    )
  }
}

export default HeroesList;
