import React from 'react'
import {
    Table,
    TableBody,
    TableHeader,
    TableHeaderColumn,
    TableRow,
    TableRowColumn,
} from 'material-ui/Table'

const Row = ( props ) => (
    <TableRow >
        <TableRowColumn >
            { props.entry.date }
        </TableRowColumn>
        <TableRowColumn >
            { props.entry.location.name }
        </TableRowColumn>
        <TableRowColumn >
            { props.entry.text }
        </TableRowColumn>
        <TableRowColumn >
            { props.entry.handled ? 'Yes' : 'No' }
        </TableRowColumn>
    </TableRow>
)

const Rows = ( props ) => props.entries.map( e => (
    <Row entry={ e } key={ e.id } />
))

const ReportsTable = ( props ) => (
    <Table 
        fixedHeader={ true }
        selectable={ false }
        multiSelectable={ false }>
        <TableHeader
            displaySelectAll={ false }
            adjustForCheckbox={ true }
            enableSelectAll={ false}
        >
            <TableRow >
                <TableHeaderColumn>Date</TableHeaderColumn>
                <TableHeaderColumn>Location</TableHeaderColumn>
                <TableHeaderColumn>Issue</TableHeaderColumn>
                <TableHeaderColumn>Handled</TableHeaderColumn>
            </TableRow>
        </TableHeader>
        <TableBody displayRowCheckbox={ false }>
            <Rows entries={ props.entries } />
        </TableBody>
    </Table>
)

export default ReportsTable
